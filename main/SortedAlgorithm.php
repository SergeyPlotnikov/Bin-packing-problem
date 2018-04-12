<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:24
 */
namespace main;

/**
 * Класс упорядоченных алгоритомов
 * Class SortedAlgorithm
 * @package main
 */
class SortedAlgorithm extends Algorithm
{
    public function __construct(Strategy $strategy)
    {
        parent::__construct($strategy);
    }

    public function executeAlgorithm():array
    {
        //Сортировка грузов в порядке убывания
        $listItems = $this->strategy->getListItems();
        usort($listItems, function (Item $a, Item $b) {
            $aCost = $a->getItemSize();
            $bCost = $b->getItemSize();
            if ($aCost == $bCost) return 0;
            return $aCost > $bCost ? -1 : 1;
        });

        $this->strategy->setListItems($listItems);
        return $this->strategy->fillContainer();
    }



}