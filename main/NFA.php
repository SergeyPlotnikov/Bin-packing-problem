<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:21
 */
namespace main;

/**
 * Описывает алгоритм NFA
 * Class NFA
 * @package main
 */
class NFA extends Strategy
{
    public function __construct(array $items)
    {
        parent::__construct($items);
    }

    function fillContainer():array
    {
        //Кол-во сравнений
        $countComparisons = 0;
        foreach ($this->listItems as $item) {
            //Определяем размер элемента
            $itemSize = $item->getItemSize();
            //Находим размер свободного места в текущем контейнере
            $freeContainerCapacity = $this->currentContainer->getFreeContainerCapacity();
            //Если есвть свободное место
            if ($freeContainerCapacity >= $itemSize) {
                $countComparisons++;
                //Добавляем элемент в контейнер и обновляем заполненность контейнера
                $this->currentContainer->addItem($item);
                $this->currentContainer->updateContainerSize($itemSize);
            } else {
                $countComparisons++;
                //Создаем новый
                $this->createContainer($item, $itemSize);
            }
        }
        return ['countContainers' => count($this->listContainers), 'countComparisons' => $countComparisons];
    }
}