<?php

/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace CodesWholesale;

use \fkooman\OAuth\Client\ClientConfig;
use \fkooman\OAuth\Client\ClientConfigInterface;
use \fkooman\OAuth\Client\ClientConfigException;
use fkooman\OAuth\Client\StorageInterface;

class CodesWholesaleClientConfig extends ClientConfig implements ClientConfigInterface
{
    private $baseUrl;
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var
     */
    private $clientHeaders;

    public function __construct(array $data)
    {
        if (!isset($data)) {
            throw new ClientConfigException("no configuration found");
        }

        foreach (array('cw.client_id', 'cw.client_secret', 'cw.endpoint_uri', 'cw.token_storage') as $key) {
            if (!isset($data[$key])) {
                throw new ClientConfigException(sprintf("missing field '%s'", $key));
            }
        }

        $this->baseUrl = $data['cw.endpoint_uri'];
        $this->storage = $data['cw.token_storage'];
        $this->clientHeaders = isset($data['cw.client.headers']) ? $data['cw.client.headers'] : array();

        $clientData = array(
            "client_id" => $data['cw.client_id'],
            "client_secret" => $data['cw.client_secret'],
            "token_endpoint" => $data['cw.endpoint_uri'] . '/oauth/token',
            "credentials_in_request_body" => true,
            "authorize_endpoint" => $data['cw.endpoint_uri'] // not used with CW use case
        );

        parent::__construct($clientData);
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * @return StorageInterface
     */
    public function getStorage() {
        return $this->storage;
    }

    /**
     * @return mixed
     */
    public function getClientHeaders() {
        return $this->clientHeaders;
    }
}
