<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:21
 */
namespace main;

/**
 * Отвечает за выбор отпределенного алгоритма заполнения контейнера
 * Class Strategy
 * @package main
 */
abstract class Strategy
{

    protected $listItems = [];
    protected $listContainers = [];
    protected $currentContainer;

    protected function __construct(array $items)
    {
        //Добавим веса грузов в список весов
        $this->addItems($items);
        //Создадим новый контейнер для грузов и отметим его как текущим
        $this->currentContainer = new Container();
        $this->listContainers[] = $this->currentContainer;
    }

    /**
     * Добавление вещей в список вещей
     * @param array $items
     */
    private function addItems(array $items)
    {
        foreach ($items as $size) {
            $this->listItems[] = new Item($size);
        }
    }

    /**
     * Получение списка грузов
     * @return array
     */
    public function getListItems(): array
    {
        return $this->listItems;
    }

    /**
     * Установка списка грузов
     * @param array $listItems
     */
    public function setListItems(array $listItems)
    {
        $this->listItems = $listItems;
    }

    /**
     * Получение списка контейнеров
     * @return array
     */
    public function getListContainers(): array
    {
        return $this->listContainers;
    }

    /**
     * Заполнение контйнеров
     * @return array
     */
    abstract function fillContainer():array;

    /**
     * Создание нового контйнера
     * @param Item $item
     * @param int $itemSize
     */
    protected function createContainer(Item $item, int $itemSize):void
    {
        $this->currentContainer = new Container();
        $this->currentContainer->addItem($item);
        $this->currentContainer->updateContainerSize($itemSize);
        $this->listContainers[] = $this->currentContainer;
        return;
    }


    /**
     * Расчет минимального колличества контйнеров, необходимых для упаковки груза
     * @return int
     */
    public function minCountContainers():int
    {
        $sum = 0;
        foreach ($this->listItems as $item) {
            $sum += $item->getItemSize();
        }
        return ceil($sum / $this->currentContainer->getContainerCapacity());
    }
}