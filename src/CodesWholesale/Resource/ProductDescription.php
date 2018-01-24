<?php

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;

class ProductDescription extends Resource
{
    const LOCALIZED_TITLES = "localizedTitles";
    const PEGI_RATING = "pegirating";
    const PLATFORM = "platform";
    const FACT_SHEETS = "factSheets";
    const RELEASES = "releases";
    const EDITIONS = "editions";
    const DEVELOPER_HOME_PAGE = "developerHomepage";
    const KEYWORDS = "keywords";
    const IN_THE_GAME_LANGUAGES = "inTheGameLanguages";
    const OFFICIAL_TITLE = "officialTitle";
    const DEVELOPER_NAME = "developerName";
    const EANS = "eans";
    const LAST_UPDATED = "lastUpdated";
    const CATEGORY = "category";
    const PHOTOS = "photos";
    const EXTENSION_PACKS = "extensionPacks";
    const VIDEOS = "videos";
    const PRODUCT_ID = "productId";

    /**
     * @param $href
     * @param array $options
     * @return ProductDescription|object
     */
    public static function get($href, array $options = array())
    {
        return Client::get($href, CodesWholesale::PRODUCT_DESCRIPTION, null, $options);
    }

    /**
     * @return array
     */
    public function getLocalizedTitles()
    {
        return $this->getProperty(self::LOCALIZED_TITLES);
    }

    /**
     * @return string
     */
    public function getPegiRating()
    {
        return $this->getProperty(self::PEGI_RATING);
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->getProperty(self::PLATFORM);
    }

    /**
     * @return array
     */
    public function getFactSheets()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::FACT_SHEET,
            $this->getProperty(self::FACT_SHEETS)
        );
    }

    /**
     * @return array
     */
    public function getReleases()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::RELEASE,
            $this->getProperty(self::RELEASES)
        );
    }

    /**
     * @return array
     */
    public function getEditions()
    {
        return $this->getProperty(self::EDITIONS);
    }

    /**
     * @return string
     */
    public function getDeveloperHomepage()
    {
        return $this->getProperty(self::DEVELOPER_HOME_PAGE);
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->getProperty(self::KEYWORDS);
    }

    /**
     * @return array
     */
    public function getGameLanguages()
    {
        return $this->getProperty(self::IN_THE_GAME_LANGUAGES);
    }

    /**
     * @return string
     */
    public function getOfficialTitle()
    {
        return $this->getProperty(self::OFFICIAL_TITLE);
    }

    /**
     * @return string
     */
    public function getDeveloperName()
    {
        return $this->getProperty(self::DEVELOPER_NAME);
    }

    /**
     * @return array
     */
    public function getEanCodes()
    {
        return $this->getProperty(self::EANS);
    }

    /**
     * @return string
     */
    public function getLastUpdate()
    {
        return $this->getProperty(self::LAST_UPDATED);
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->getProperty(self::CATEGORY);
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::PHOTO,
            $this->getProperty(self::PHOTOS)
        );
    }

    /**
     * @return array
     */
    public function getExtensionPacks()
    {
        return $this->getProperty(self::EXTENSION_PACKS);
    }

    /**
     * @return array
     */
    public function getVideos()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::VIDEO,
            $this->getProperty(self::VIDEOS)
        );
    }

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }


}
