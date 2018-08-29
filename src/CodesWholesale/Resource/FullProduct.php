<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/08/2018
 * Time: 13:46
 */

namespace CodesWholesale\Resource;


use CodesWholesale\CodesWholesale;
use CodesWholesale\Exceptions\NoImagesFoundException;

class FullProduct extends Resource
{
    const PRODUCT_ID = "productId";
    const IDENTIFIER = "identifier";
    const NAME = "name";
    const PLATFORM = "platform";
    const QUANTITY = "quantity";
    const IMAGES = "images";
    const REGIONS = "regions";
    const LANGUAGES = "languages";
    const PRICES = "prices";
    const OFFICIAL_TITLE = "officialTitle";
    const CATEGORY = "category";
    const PEGI_RATING = "pegiRating";
    const DEVELOPER_NAME = "developerName";
    const DEVELOPER_HOMEPAGE = "developerHomepage";
    const KEYWORDS = "keywords";
    const PHOTOS = "photos";
    const LOCALIZED_TITLES = "localizedTitles";
    const IN_THE_GAME_LANGUAGES = "inTheGameLanguages";
    const RELEASES = "releases";
    const FACT_SHEETS = "factSheets";
    const EXTENSION_PACKS = "extensionsPacks";
    const EDITIONS = "editions";
    const VIDEOS = "videos";
    const MIN_REQUIREMENTS = "minimumRequirements";
    const REC_REQUIREMENTS = "recommendedRequirements";
    const RELEASE_DATE = "releaseDate";
    const LAST_UPDATED = "lastUpdated";
    const EANS = "eans";

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
    public function getIdentifier()
    {
        return $this->getProperty(self::IDENTIFIER);
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
    public function getPlatform()
    {
        return $this->getProperty(self::PLATFORM);
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getProperty(self::QUANTITY);
    }

    /**
     * @param $format
     * @return string
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
     * @return string[]
     */
    public function getRegions()
    {
        return $this->getProperty(self::REGIONS);
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->getProperty(self::LANGUAGES);
    }

    /**
     * @return Price[]
     */
    public function getPrices()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesale::PRICE,
            $this->getProperty(self::PRICES)
        );
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
    public function getCategory()
    {
        return $this->getProperty(self::CATEGORY);
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
    public function getDeveloperName()
    {
        return $this->getProperty(self::DEVELOPER_NAME);
    }

    /**
     * @return string
     */
    public function getDeveloperHomepage()
    {
        return $this->getProperty(self::DEVELOPER_HOMEPAGE);
    }

    /**
     * @return array[]
     */
    public function getKeywords()
    {
        return $this->getProperty(self::KEYWORDS);
    }

    /**
     * @return Photo[]
     */
    public function getPhotos()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::PHOTO,
            $this->getProperty(self::PHOTOS)
        );
    }

    /**
     * @return LocalizedTitle[]
     */
    public function getLocalizedTitles()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::LOCALIZED_TITLE,
            $this->getProperty(self::LOCALIZED_TITLES)
        );
    }

    /**
     * @return string[]
     */
    public function getInTheGameLanguages()
    {
        return $this->getProperty(self::IN_THE_GAME_LANGUAGES);
    }

    /**
     * @return Release[]
     */
    public function getReleases()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::RELEASE,
            $this->getProperty(self::RELEASES)
        );
    }

    /**
     * @return FactSheet[]
     */
    public function getFactSheets()
    {
        return $this->dataStore->instantiateByArrayOf(
            ProductDescriptionFieldContainer::FACT_SHEET,
            $this->getProperty(self::FACT_SHEETS)
        );
    }

    /**
     * @return string[]
     */
    public function getExtensionPacks()
    {
        return $this->getProperty(self::EXTENSION_PACKS);
    }

    /**
     * @return string[]
     */
    public function getEditions()
    {
        return $this->getProperty(self::EDITIONS);
    }

    /**
     * @return Video[]
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
    public function getMinRequirements()
    {
        return $this->getProperty(self::MIN_REQUIREMENTS);
    }

    /**
     * @return string
     */
    public function getRecRequirements()
    {
        return $this->getProperty(self::MIN_REQUIREMENTS);
    }

    /**
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->getProperty(self::RELEASE_DATE);
    }

    /**
     * @return string
     */
    public function getLastUpdated()
    {
        return $this->getProperty(self::LAST_UPDATED);
    }

    /**
     * @return string[]
     */
    public function getEans()
    {
        return $this->getProperty(self::EANS);
    }
}