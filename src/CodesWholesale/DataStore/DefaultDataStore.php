<?php

namespace CodesWholesale\DataStore;

use CodesWholesale\CodesWholesale;
use CodesWholesale\Http\DefaultRequest;
use CodesWholesale\Http\Request;
use CodesWholesale\Http\RequestExecutor;
use CodesWholesale\Resource\Error;
use CodesWholesale\Resource\ExceptionResource;
use CodesWholesale\Resource\Resource;
use CodesWholesale\Resource\ResourceError;
use CodesWholesale\Util\Version;
use Exception;
use GuzzleHttp\Exception\ClientException;
use InvalidArgumentException;

class DefaultDataStore implements InternalDataStore
{
    private $requestExecutor;
    private $resourceFactory;
    private $baseUrl;

    public function __construct(RequestExecutor $requestExecutor, $baseUrl = null)
    {
        $this->requestExecutor = $requestExecutor;
        $this->resourceFactory = new DefaultResourceFactory($this);
        $this->baseUrl = $baseUrl;
    }

    public function instantiateByArrayOf($className, array $arrayOfObjects = array())
    {
        $parsedObjects = array();
        foreach ($arrayOfObjects as $objects) {
            $parsedObjects[] = $this->instantiate($className, $objects);
        }
        return $parsedObjects;
    }

    public function instantiate($className, \stdClass $properties = null, array $options = [])
    {
        $propertiesArr = [$properties, $options];
        return $this->resourceFactory->instantiate($className, $propertiesArr);
    }

    /**
     * @param $href
     * @param $className
     * @param array $options
     * @return object
     * @throws Exception
     */
    public function getResource($href, $className, array $options = [])
    {
        if ($this->needsToBeFullyQualified($href)) {
            $href = $this->qualify($href);
        }

        $queryString = $this->getQueryString($options);

        try {
            $data = $this->executeRequest(Request::METHOD_GET, $href, '', $queryString);
            return $this->resourceFactory->instantiate($className, [$data, $queryString]);
        } catch (ClientException $exception) {
            /**
             * @var ExceptionResource $exceptionResource
             */
            $exceptionResource = $this->resourceFactory->instantiate(CodesWholesale::EXCEPTION_RESOURCE, [
                json_decode($exception->getResponse()->getBody()->getContents()),
                $queryString
            ]);
            throw new Exception($exceptionResource->getMessage(), $exceptionResource->getCode());
        }
    }

    /**
     * @param $href
     * @throws Exception
     */
    public function patch($href)
    {
        try {
            $this->executeRequest(Request::METHOD_PATCH, $href, '', []);
        } catch (ClientException $exception) {
            /**
             * @var ExceptionResource $exceptionResources
             */
            $exceptionResource = $this->resourceFactory->instantiate(CodesWholesale::EXCEPTION_RESOURCE, [
                json_decode($exception->getResponse()->getBody()->getContents()), ""
            ]);
            throw new Exception($exceptionResource->getMessage(), $exceptionResource->getCode());
        }
    }

    protected function needsToBeFullyQualified($href)
    {
        return stripos($href, 'http') === false;
    }

    protected function qualify($href)
    {
        $slashAdded = '';

        if (!(stripos($href, '/') == 0)) {
            $slashAdded = '/';
        }

        return $this->baseUrl . $slashAdded . $href;
    }

    private function getQueryString(array $options)
    {
        $query = [];
        foreach ($options as $key => $opt) {
            if (is_array($opt)) {
                $opt = implode(",", $opt);
            }
            $query[$key] = !is_bool($opt) ? strval($opt) : var_export($opt, true);
        }
        return $query;
    }

    private function executeRequest($httpMethod, $href, $body = '', array $query = array())
    {
        $request = new DefaultRequest(
            $httpMethod,
            $href,
            $query,
            array(),
            $body,
            strlen($body));

        $this->applyDefaultRequestHeaders($request);

        $response = $this->requestExecutor->executeRequest($request);
        $result = $response->getBody() ? json_decode($response->getBody()) : '';

        if ($response->isError()) {
            $errorResult = $result;

            if (!$errorResult) {
                $status = $response->getHttpStatus();
                $errorResult = new \stdClass();
                $errorResult->$status = $status;
            }
            $error = new Error($errorResult);
            throw new ResourceError($error);
        }
        return $result;
    }

    private function applyDefaultRequestHeaders(Request $request)
    {
        $headers = $request->getHeaders();
        $headers['Accept'] = 'application/json';
        $headers['User-Agent'] = 'CW Plugin version:' . Version::SDK_VERSION . '';

        if ($request->getBody()) {
            $headers['Content-Type'] = 'application/json';
        }

        $request->setHeaders($headers);
    }

    public function create($parentHref, Resource $resource, $returnType, array $options = [])
    {
        $queryString = $this->getQueryString($options);
        /**
         * @var Resource $returnedResource
         */
        $returnedResource = $this->saveResource($parentHref, $resource, $returnType, $queryString);
        $returnTypeClass = $this->resourceFactory->instantiate($returnType, []);
        if ($resource instanceof $returnTypeClass) {
            $resource->setProperties($this->toStdClass($returnedResource));
        }
        return $returnedResource;
    }

    private function saveResource($href, Resource $resource, $returnType, array $query = [])
    {
        if ($this->needsToBeFullyQualified($href)) {
            $href = $this->qualify($href);
        }
        $body = json_encode($this->toStdClass($resource));
        $response = $this->executeRequest(Request::METHOD_POST, $href, $body, $query);
        return $this->resourceFactory->instantiate($returnType, [$response, $query]);
    }

    private function toStdClass(Resource $resource)
    {
        $propertyNames = $resource->getPropertyNames();
        $properties = new \stdClass();

        foreach ($propertyNames as $name) {
            $property = $resource->getProperty($name);
            if ($property instanceof Resource) {
                $additionalProperties = new \stdClass();
                foreach ($property->getPropertyNames() as $propertyName) {
                    $additionalProperty = $property->getProperty($propertyName);
                    if($additionalProperty instanceof \stdClass) {
                        $additionalProperties->$propertyName = (array) $additionalProperty;
                    } else {
                        $additionalProperties->$propertyName = $additionalProperty;
                    }
                }
                $properties->$name = $additionalProperties;
                continue;
            }

            if ($property instanceof \stdClass) {
                $property = $this->toSimpleReferences($property);
            }

            $properties->$name = $property;
        }

        return $properties;
    }

    private function toSimpleReferences(\stdClass $properties)
    {
        $products = (array)$properties;

        $simpleReferences = [];

        foreach ($products as $product) {
            $simpleReferences[] = (object)$product->getProperties();
        }
        return $simpleReferences;
    }

    public function save(Resource $resource, $returnType = null)
    {
        $href = $resource->getHref();

        if (!strlen($href)) {
            throw new InvalidArgumentException('save may only be called on objects that have already been persisted (i.e. they have an existing href).');
        }

        if ($this->needsToBeFullyQualified($href)) {
            $href = $this->qualify($href);
        }

        $returnType = $returnType ? $returnType : get_class($resource);

        $returnedResource = $this->saveResource($href, $resource, $returnType);

        //ensure the caller's argument is updated with what is returned from the server:
        $resource->setProperties($this->toStdClass($returnedResource));

        return $returnedResource;

    }

    public function delete(Resource $resource)
    {
        return $this->executeRequest(Request::METHOD_DELETE, $resource->getHref());
    }
}
