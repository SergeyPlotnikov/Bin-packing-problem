<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:24
 */
namespace main;

/**
 * Класс неупорядоченных алгоритмов
 * Class UnsortedAlgorithm
 * @package main
 */
class UnsortedAlgorithm extends Algorithm
{
    public function __construct(Strategy $strategy)
    {
        parent::__construct($strategy);
    }
}

