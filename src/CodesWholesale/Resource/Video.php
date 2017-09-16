<?php

namespace CodesWholesale\Resource;

class Video extends Resource
{
    const PREVIEW_FRAME_URL = "previewFrameURL";
    const AGE_WARNING = "ageWarning";
    const TITLE = "title";
    const RELEASE_DATE = "releaseDate";
    const URL = "url";

    /**
     * @return string
     */
    public function getPreviewFrameUrl()
    {
        return $this->getProperty(self::PREVIEW_FRAME_URL);
    }

    /**
     * @return string
     */
    public function getAgeWarning()
    {
        return $this->getProperty(self::AGE_WARNING);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getProperty(self::TITLE);
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
    public function getUrl()
    {
        return $this->getProperty(self::URL);
    }
}