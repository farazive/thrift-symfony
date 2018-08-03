<?php

namespace App\Controller;

use App\Thrift\Handler\CalculatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CalculatorController
 * @package App\Controller
 */
class CalculatorController extends Controller
{
    /**
     * @param CalculatorHandler $calculatorHandler
     */
    public function fooAction(CalculatorHandler $calculatorHandler)
    {
        echo $calculatorHandler->add(1,2);
        die;
    }
}