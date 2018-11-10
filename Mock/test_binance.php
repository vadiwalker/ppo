<?php

use PHPUnit\Framework\TestCase;

include 'binance.php';

class StubTest extends TestCase
{
    public function testStub() {
    	$originalClassName = 'BinanceServer';

        // Create a stub for the SomeClass class.
        $stubServer = $this->getMockBuilder($originalClassName)
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableArgumentCloning()
                     ->disallowMockingUnknownTypes()
                     ->getMock();

        // Configure the stub.
        $stubServer->method('getBase')
             ->willReturn('https://reddle.ru');

        $stubMethodManager = $this->getMockBuilder('BinanceMethodManager')
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableArgumentCloning()
                     ->disallowMockingUnknownTypes()
                     ->getMock();

        $stubMethodManager->method('allPricesMethod')
        					->willReturn('/stubserver/stub.php');

        $api_key = "ig0pJFMhnvXXGzgkVFtQi97DYIADCmVHE4qJWRzLRkRxaPXLeRi1GJ2mYPqbAkfy";
		$api_secret = "YzxCi4IRbVgBQYP0W63eeZl8nQtukbQPdpp8fBAhGMLInvWL2BApND9WGosUcKJA";

        $binance = new Binance($api_key, $api_secret, new Connection($stubServer), $stubMethodManager);

        // Stub Server returns exchange rate 6500

        $coin = 'BTCUSDT';
        $this->assertEquals($binance->price($coin), 6500);

        // Calling $stub->doSomething() will now return
        // 'foo'.

        // $this->assertEquals('foo', $stub->doSomething());
    }

    public function testConnection() {
    	$connection = new Connection(new Server('https://reddle.ru'));
    	$response = $connection->request('/stubserver/ping.php');
    	$this->assertEquals($response['ok'], true);
    }
}

$stubTest = new StubTest();
$stubTest->testStub();

?>