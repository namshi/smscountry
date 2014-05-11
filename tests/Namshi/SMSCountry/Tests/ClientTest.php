<?php

namespace Namshi\SMSCountry\Tests;

use \PHPUnit_Framework_TestCase;
use \PHPUnit_Framework_MockObject_MockObject;
use Namshi\SMSCountry\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $username = 'user';
    protected $password = 'password';
    protected $senderId = 'sender';

    /** @var  Client */
    private $client;
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    private $clientMock;

    public function setUp()
    {
        parent::setUp();
        $this->clientMock = $this->getMock("SoapClient", array('SendUnicodeSMS'), array(), '', false);
        $this->client     = $this->getClient();
    }

    public function testSoapClientIsCalled()
    {
        $phoneNumber           = '+971 50 555 555';
        $normalizedPhoneNumber = '97150555555';
        $message               = 'this is a message';

        $this->clientMock->expects($this->once())
                         ->method('SendUnicodeSMS')
                         ->with(array(
                                    "username"      => $this->username,
                                    "password"      => $this->password,
                                    "mobilenumbers" => $normalizedPhoneNumber,
                                    "message"       => $message,
                                    "senderID"      => $this->senderId
                                )
            );

        $this->client->sendSms($phoneNumber, $message);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client($this->username, $this->password, $this->senderId, $this->clientMock);
    }
}