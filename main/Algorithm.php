<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 0:23
 */
namespace main;

abstract class Algorithm
{
    /**
     * @var Strategy $strategy
     */
    protected $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }


    /**
     * @return Strategy
     */
    public function getStrategy(): Strategy
    {
        return $this->strategy;
    }

    /**
     * Заполнить контейнеры грузом в соответствии с выбранным алгоритмом
     * @return array
     */
    public function executeAlgorithm():array
    {
        return $this->strategy->fillContainer();
    }


}