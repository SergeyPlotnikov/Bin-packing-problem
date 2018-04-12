<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 10.04.2018
 * Time: 23:30
 */
namespace main;

class Container
{
    //вместимость контейнера
    private $containerCapacity = 100;
    //заполненность контейнера
    private $containerSize = 0;
    //Массив элементов в контейнере
    private $items = [];

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     *
     * @return int
     */
    public function getContainerCapacity():int
    {
        return $this->containerCapacity;
    }

    /**
     * @return mixed
     */
    public function getContainerSize()
    {
        return $this->containerSize;
    }


    /**
     * Добавление элемента в контейнер
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * Изменение заполненности конейнера
     * @param int $size
     */
    public function updateContainerSize(int $size)
    {
        $this->containerSize += $size;
    }

    /**
     * Получение свободного места в контейнере
     * @return int
     */
    public function getFreeContainerCapacity():int
    {
        return $this->containerCapacity - $this->containerSize;
    }
}