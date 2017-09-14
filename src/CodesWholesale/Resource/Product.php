<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;


use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use CodesWholesale\Exceptions\NoImagesFoundException;

class Product extends Resource
{

    const NAME = "name";
    const IDENTIFIER = "identifier";
    const PLATFORM = "platform";
    const REGIONS = "regions";
    const LANGUAGES = "languages";
    const PRICES = "prices";
    const BUY_HREF_REL_NAME = "buy";
    const DESCRIPTION_HREF_REL_NAME = "description";
    const PRODUCT_ID = "productId";
    const RELEASE_DATE = "releaseDate";
    const QUANTITY = "quantity";
    const IMAGES = "images";
    const PATH = "products";

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @param $href
     * @param array $options
     * @return \CodesWholesale\Resource\Product
     */
    public static function get($href, array $options = array())
    {
        return Client::get($href, CodesWholesale::PRODUCT, self::PATH, $options);
    }

    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }

    public function getName()
    {
        return $this->getProperty(self::NAME);
    }

    public function getIdentifier()
    {
        return $this->getProperty(self::IDENTIFIER);
    }

    public function getPlatform()
    {
        return $this->getProperty(self::PLATFORM);
    }

    public function getRegions()
    {
        return $this->getProperty(self::REGIONS);
    }

    public function getLanguages()
    {
        return $this->getProperty(self::LANGUAGES);
    }

    public function getReleaseDate()
    {
        return $this->getProperty(self::RELEASE_DATE);
    }

    /**
     * @param string $locale
     * @return ProductDescription
     */
    public function getProductDescription($locale = null)
    {
        if($locale){
            return ProductDescription::get($this->getDescriptionHref() . "?locale=" . $locale);
        }
        return ProductDescription::get($this->getDescriptionHref());
    }

    /**
     * @param $format
     * @return mixed
     * @throws NoImagesFoundException
     */
    public function getImageUrl($format)
    {
        $images = $this->getProperty(self::IMAGES);
        foreach ($images as $image) {
            if ($image->format == $format)
                return $image->image;
        }
        throw new NoImagesFoundException();
    }

    /**
     * @return array
     */
    public function getPrices()
    {
        return $this->getProperty(self::PRICES);
    }

    /**
     * @return int
     */
    public function getStockQuantity()
    {
        return $this->getProperty(self::QUANTITY);
    }

    /**
     * Returns first price range's price. The one from price list.
     *
     * @return decimal
     */
    public function getDefaultPrice()
    {
        $prices = $this->getPrices();
        foreach ($prices as $price) {
            if ($price->from == 1) {
                return $price->value;
            }
        }
    }

    /**
     * Returns lowest price for product.
     *
     * @return decimal
     */
    public function getLowestPrice()
    {
        $prices = $this->getPrices();
        $lowest = $prices[0]->value;
        foreach ($prices as $price) {
            if ($price->value < $lowest) {
                $lowest = $price->value;
            }
        }
        return $lowest;
    }

    /**
     * @return string|uri
     */
    public function getBuyHref()
    {
        return $this->getHrefRel(self::BUY_HREF_REL_NAME);
    }

    /**
     * @return string|uri
     */
    public function getDescriptionHref()
    {
        return $this->getHrefRel(self::DESCRIPTION_HREF_REL_NAME);
    }
} 