<?php

namespace Namshi\SMSCountry\Test;

use Namshi\SMSCountry\Client;
use \PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $username = 'user';
    protected $password = 'password';
    protected $senderId = 'sender';
    protected $serviceWsdlUrl = 'http://www.smscountry.com/service.asmx?WSDL';

    public function testSendingSmsWithInvalidCredentials()
    {

        $client      = new Client($this->username, $this->password, $this->senderId, $this->serviceWsdlUrl);
        $phoneNumber = '12345678';
        $message     = 'this is our message';

        $this->assertInstanceOf("Namshi\\SMSCountry\\Client", $client);
        $this->assertFalse($client->sendSms($phoneNumber, $message));
    }

    public function testSendingValidRequest()
    {
        $phoneNumber = '12345678';
        $message     = 'this is our message';

        $clientMock = $this->getMock(
            "Namshi\\SMSCountry\\Client",
            array('sendSms'),
            array(
                $this->username,
                $this->password,
                $this->senderId,
                $this->serviceWsdlUrl
            )
        );

        $clientMock->expects($this->any())->method('sendSms')->will($this->returnValue(true));
        $this->assertTrue($clientMock->sendSms($phoneNumber, $message));
    }
}