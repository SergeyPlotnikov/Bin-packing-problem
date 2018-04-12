<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:22
 */
namespace main;

/**
 * Описывает алгоритм FFA
 * Class FFA
 * @package main
 */
class FFA extends Strategy
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

            //Если груз помещается в текущий контйнер, то добавим его в него
            if ($freeContainerCapacity >= $itemSize) {
                $countComparisons++;
                $this->currentContainer->addItem($item);
                $this->currentContainer->updateContainerSize($itemSize);
            } else {
                $countComparisons++;
                $done = false;
                //Находим контейнер, который может вместить в себя текущий груз
                foreach ($this->listContainers as $container) {
                    $freeContainerCapacity = $container->getFreeContainerCapacity();
                    if ($freeContainerCapacity >= $itemSize) {
                        $countComparisons++;
                        $container->addItem($item);
                        $container->updateContainerSize($itemSize);
                        $done = true;
                        break;
                    }
                }
                if (!$done) {
                    $countComparisons++;
                    //Создаем новый контейнер
                    $this->createContainer($item, $itemSize);
                }
            }
        }
        return ['countContainers' => count($this->listContainers), 'countComparisons' => $countComparisons];
    }
}