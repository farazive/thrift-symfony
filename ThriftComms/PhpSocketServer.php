<?php

namespace tutorial\php;

use App\Kernel;
use App\Thrift\Handler\CalculatorHandler;
use Overblog\ThriftBundle\Listener\ClassLoaderListener;
use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Server\TServerSocket;
use Thrift\Server\TSimpleServer;
use ThriftModel\Calculator\CalculatorProcessor;

error_reporting( E_ALL );

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . "/../var/cache/dev";
ClassLoaderListener::registerClassLoader( $cacheDir );


$GEN_DIR = realpath( dirname( __FILE__ ) . '/..' ) . '/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace( 'Thrift', __DIR__ . '/../../lib/php/lib' );
$loader->registerDefinition( 'shared', $GEN_DIR );
$loader->registerDefinition( 'tutorial', $GEN_DIR );
$loader->register();

if ( php_sapi_name() == 'cli' ) {
    ini_set( "display_errors", "stderr" );
}


header( 'Content-Type', 'application/x-thrift' );

if ( php_sapi_name() == 'cli' ) {
    echo "\r\n";
}

$kernel = new Kernel( 'dev', true);
$kernel->boot();

$handler = new CalculatorHandler($kernel->getContainer());

$processor = new CalculatorProcessor( $handler );

/**
 * HTTP SERVER
 *
 * $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
 * $protocol = new TBinaryProtocol($transport, true, true);
 *
 * $transport->open();
 * $processor->process($protocol, $protocol);
 * $transport->close();
 */

$transport = new TServerSocket();
$transportFactory = new TTransportFactory();
$protocolFactory = new TBinaryProtocolFactory();
$server = new TSimpleServer(
    $processor,
    $transport,
    $transportFactory,
    $transportFactory,
    $protocolFactory,
    $protocolFactory
);

$server->serve();
