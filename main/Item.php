<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 10.04.2018
 * Time: 23:30
 */
namespace main;

/**
 * Описывает груз
 * Class Item
 * @package main
 */
class Item
{
    private $itemSize;

    public function __construct(int $size)
    {
        $this->itemSize = $size;
    }

    /**
     * @return int
     */
    public function getItemSize()
    {
        return $this->itemSize;
    }
}