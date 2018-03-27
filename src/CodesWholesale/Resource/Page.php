<?php

namespace CodesWholesale\Resource;

use CodesWholesale\Util\Magic;

class Page extends Magic
{
    private $offset;
    private $limit;
    private $items;

    public function __construct($offset, $limit, array $items)
    {
        parent::__construct();
        $this->items = $items;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getOffset()
    {
        return $this->offset;
    }

}
