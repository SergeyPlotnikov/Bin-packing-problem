<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:22
 */
namespace main;

/**
 * Описывает алгоритм BFA
 * Class BFA
 * @package main
 */
class BFA extends Strategy
{
    public function __construct(array $items)
    {
        parent::__construct($items);
    }

    function fillContainer():array
    {
        $countComparisons = 0;
        foreach ($this->listItems as $item) {
            $itemSize = $item->getItemSize();
            $freeContainerCapacity = $this->currentContainer->getFreeContainerCapacity();
            if ($freeContainerCapacity >= $itemSize) {
                $countComparisons++;
                $this->currentContainer->addItem($item);
                $this->currentContainer->updateContainerSize($itemSize);
            } else {
                $countComparisons++;
                $minFreeCapacity = PHP_INT_MAX;
                $this->currentContainer = null;
                //Находим максимально заполненный контейнер, который способен вместить данный груз
                foreach ($this->listContainers as $container) {
                    $curContainerFreeCapacity = $container->getFreeContainerCapacity();
                    if ($curContainerFreeCapacity < $minFreeCapacity && $curContainerFreeCapacity >= $itemSize) {
                        $countComparisons++;
                        $minFreeCapacity = $curContainerFreeCapacity;
                        $this->currentContainer = $container;
                    }
                }
                //если нашли подходящий контейнер, то добавим в него груз
                if (!is_null($this->currentContainer)) {
                    $countComparisons++;
                    $this->currentContainer->addItem($item);
                    $this->currentContainer->updateContainerSize($itemSize);
                    //Установим последний контейнер списка как текущий
                    $this->currentContainer = end($this->listContainers);
                } else {
                    //Создаем новый
                    $countComparisons++;
                    $this->createContainer($item, $itemSize);
                }
            }
        }
        return ['countContainers' => count($this->listContainers), 'countComparisons' => $countComparisons];
    }
}