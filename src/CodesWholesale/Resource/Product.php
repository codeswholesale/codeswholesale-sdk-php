<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 08/12/2017
 * Time: 11:53
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

    const PATH = "v2/products";

    /**
     * @param $href
     * @return Product|object
     * @throws \Exception
     */
    public static function get($href)
    {
        return Client::get($href, CodesWholesale::PRODUCT, self::PATH);
    }

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getProperty(self::NAME);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getProperty(self::IDENTIFIER);
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->getProperty(self::PLATFORM);
    }

    /**
     * @return string
     */
    public function getRegions()
    {
        return $this->getProperty(self::REGIONS);
    }

    /**
     * @return string
     */
    public function getLanguages()
    {
        return $this->getProperty(self::LANGUAGES);
    }

    /**
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->getProperty(self::RELEASE_DATE);
    }

    /**
     * @param null $locale
     * @return ProductDescription|object
     * @throws \Exception
     */
    public function getProductDescription($locale = null)
    {
        $href = $this->getDescriptionHref();
        if ($locale) {
            $href .= "?locale=" . $locale;
        }
        return ProductDescription::get($href);
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
     * @return float
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
     * @return float
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
     * @return string
     */
    public function getBuyHref()
    {
        return $this->getHrefRel(self::BUY_HREF_REL_NAME);
    }

    /**
     * @return string
     */
    public function getDescriptionHref()
    {
        return $this->getHrefRel(self::DESCRIPTION_HREF_REL_NAME);
    }
}