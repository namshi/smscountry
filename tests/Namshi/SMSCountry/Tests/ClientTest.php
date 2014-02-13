<?php

namespace Namshi\SMSCountry\Tests;

use \PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $username       = 'user';
    protected $password       = 'password';
    protected $senderId       = 'sender';
    protected $serviceWsdlUrl = 'anyhttp';

    /**
     * @Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client  = $this->getMockedClient();
    }

    public function testSendingSmsWithInvalidCredentials()
    {
        $phoneNumber = '12345678';
        $message     = 'this is a message';

        $this->assertInstanceOf('Namshi\SMSCountry\Client', $this->client);
        $this->assertFalse($this->client->sendSms($phoneNumber, $message));
    }

    public function testSendingValidRequest()
    {
        $phoneNumber = '123456';
        $message     = 'message';

        $this->assertTrue($this->client->sendSms($phoneNumber, $message));
    }

    public function testNormalizingPhone()
    {
        $phoneNumbers = array(
            '123456789',
            '+123 - 45 - 6789',
            '+ 123 (45) 6789',
            '123[456]789'
        );

        foreach ($phoneNumbers as $phoneNumber) {
            $this->assertEquals('123456789', $this->client->normalizePhoneNumber($phoneNumber));
        }
    }

    /**
     * @return Client
     */
    protected function getMockedClient()
    {
        return new Client($this->username, $this->password, $this->senderId, $this->serviceWsdlUrl);
    }
}