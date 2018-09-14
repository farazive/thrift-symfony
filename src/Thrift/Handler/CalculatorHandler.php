<?php

namespace App\Thrift\Handler;

use Overblog\ThriftBundle\Api\Extensions\BaseExtension;
use ThriftModel\Calculator\CalculatorIf;
use ThriftModel\Calculator\InvalidOperation;
use ThriftModel\Calculator\Operation;
use ThriftModel\Calculator\Work;
use ThriftModel\Shared\SharedStruct;

/**
 * WARNING: If you change this file, you need to run compsoer install again. Clearing cache without doing a composer
 * install will cause an error
 *
 * Class CalculatorHandler
 * @package App\Thrift\Handler
 */
class CalculatorHandler extends BaseExtension implements CalculatorIf
{
    protected $log = array();

    /**
     * A method definition looks like C code. It has a return type, arguments,
     * and optionally a list of exceptions that it may throw. Note that argument
     * lists and exception lists are specified using the exact same syntax as
     * field lists in struct or exception definitions.
     *
     */
    public function ping()
    {
        error_log("ping()");
    }

    /**
     * @param int $num1
     * @param int $num2
     *
     * @return int
     */
    public function add($num1, $num2)
    {
        error_log("add({$num1}, {$num2})");
        return $num1 + $num2;
    }

    /**
     * @param int $logid
     * @param Work $w
     *
     * @return int
     * @throws InvalidOperation
     */
    public function calculate($logid, Work $w)
    {
        {
            error_log("calculate({$logid}, {{$w->op}, {$w->num1}, {$w->num2}})");
            switch ($w->op) {
                case Operation::ADD:
                    $val = $w->num1 + $w->num2;
                    break;
                case Operation::SUBTRACT:
                    $val = $w->num1 - $w->num2;
                    break;
                case Operation::MULTIPLY:
                    $val = $w->num1 * $w->num2;
                    break;
                case Operation::DIVIDE:
                    if ($w->num2 == 0) {
                        $io = new InvalidOperation();
                        $io->whatOp = $w->op;
                        $io->why = "Cannot divide by 0";
                        throw $io;
                    }
                    $val = $w->num1 / $w->num2;
                    break;
                default:
                    $io = new InvalidOperation();
                    $io->whatOp = $w->op;
                    $io->why = "Invalid Operation";
                    throw $io;
            }

            $log = new SharedStruct();
            $log->key = $logid;
            $log->value = (string)$val;
            $this->log[$logid] = $log;

            return $val;
        }
    }

    /**
     * This method has a oneway modifier. That means the client only makes
     * a request and does not listen for any response at all. Oneway methods
     * must be void.
     *
     */
    public function zip()
    {
        error_log("zip()");
    }


    /**
     * @param int $key
     *
     * @return SharedStruct
     */
    public function getStruct($key)
    {
        error_log("getStruct({$key})");
        // This actually doesn't work because the PHP interpreter is
        // restarted for every request.
        //return $this->log[$key];
        return new SharedStruct(array("key" => $key, "value" => "PHP is stateless!"));
    }
}