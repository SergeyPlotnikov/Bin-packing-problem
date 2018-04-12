<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:22
 */
namespace main;

/**
 * Описывает алгоритм WFA
 * Class WFA
 * @package main
 */
class WFA extends Strategy
{

    public function __construct(array $items)
    {
        parent::__construct($items);
    }

    function fillContainer():array
    {
        $countComparisons = 0;
        foreach ($this->listItems as $item) {
            //Определяем размер элемента
            $itemSize = $item->getItemSize();
            //Находим размер свободного места в текущем контейнере
            $freeContainerCapacity = $this->currentContainer->getFreeContainerCapacity();
            if ($freeContainerCapacity >= $itemSize) {
                $countComparisons++;
                $this->currentContainer->addItem($item);
                $this->currentContainer->updateContainerSize($itemSize);
            } else {
                $countComparisons++;
                $maxFreeCapacity = PHP_INT_MIN;
                $this->currentContainer = null;
                foreach ($this->listContainers as $container) {
                    //Находим контейнер с наибольшим кол-вом свободного места
                    $curContainerFreeCapacity = $container->getFreeContainerCapacity();
                    if ($curContainerFreeCapacity > $maxFreeCapacity) {
                        $countComparisons++;
                        $maxFreeCapacity = $curContainerFreeCapacity;
                        $this->currentContainer = $container;
                    }
                }
                //Если груз влазит в контейнер, то добавляем его туда
                if ($maxFreeCapacity >= $itemSize) {
                    $countComparisons++;
                    $this->currentContainer->addItem($item);
                    $this->currentContainer->updateContainerSize($itemSize);
                    //Назначаем текущим контейнером самый поседний в списке
                    $this->currentContainer = end($this->listContainers);
                } else {
                    $countComparisons++;
                    //Создаем новый
                    $this->createContainer($item, $itemSize);
                }
            }
        }
        return ['countContainers' => count($this->listContainers), 'countComparisons' => $countComparisons];
    }
}