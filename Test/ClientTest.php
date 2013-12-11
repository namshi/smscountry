<?php

namespace Namshi\SmsCountry\Test;

use Namshi\Smscountry\Client;
use \PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;
    protected $username = 'user';
    protected $password = 'password';
    protected $senderId = 'sender';
    protected $serviceWsdlUrl = 'http://www.smscountry.com/service.asmx?WSDL';

    public function setUp()
    {
        $this->client = new Client($this->username, $this->password, $this->senderId, $this->serviceWsdlUrl);
    }

    public function testCreationOfTheClient()
    {
        $this->assertInstanceOf("Namshi\\SmsCountry\\Client", $this->client);
    }

    public function testSendingSmsWithInvalidCredentials()
    {
        $phoneNumber = '12345678';
        $message     = 'this is our message';
        $this->assertFalse($this->client->sendSms($phoneNumber, $message));
    }
}