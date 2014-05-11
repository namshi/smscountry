<?php

namespace Namshi\SMSCountry\Tests;

use \ReflectionClass;
use \PHPUnit_Framework_TestCase;
use \PHPUnit_Framework_MockObject_MockObject;
use Namshi\SMSCountry\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $username                 = 'user';
    protected $password                 = 'password';
    protected $senderId                 = 'sender';
    protected $nonUnicodeString         = 'this is not an unicode string';
    protected $unicodeString            = 'الله أَكْبَر';
    protected $phoneNumber              = '+971 50 555 555';
    protected $normalizedPhoneNumber    = '97150555555';

    /** @var  Client */
    private $client;

    /** @var  PHPUnit_Framework_MockObject_MockObject */
    private $clientMock;

    public function setUp()
    {
        parent::setUp();
        $this->clientMock = $this->getMock("SoapClient", array('SendUnicodeSMS', 'SendTextSMS'), array(), '', false);
        $this->client     = $this->getClient();
    }

    public function testPhoneNumberIsNormalized()
    {

        $normalizePhoneNumberMethod = self::getClientMethod('normalizePhoneNumber');
        $processedPhoneNumber       = $normalizePhoneNumberMethod->invokeArgs($this->client, array($this->phoneNumber));

        $this->assertEquals($this->normalizedPhoneNumber, $processedPhoneNumber);
    }

    public function testNonUnicodeStringIsRecognized()
    {

        $isUnicodeStringMethod = self::getClientMethod('isUnicodeString');
        $isUnicodeString       = $isUnicodeStringMethod->invokeArgs($this->client, array($this->nonUnicodeString));

        $this->assertEquals($isUnicodeString, false);
    }

    public function testUnicodeStringIsRecognized()
    {

        $isUnicodeStringMethod = self::getClientMethod('isUnicodeString');
        $isUnicodeString       = $isUnicodeStringMethod->invokeArgs($this->client, array($this->unicodeString));

        $this->assertEquals($isUnicodeString, true);
    }

    public function testSendingNonUnicodeMessageCallsSendTextSmsSoapMethod()
    {
        $this->clientMock->expects($this->once())
                         ->method('SendTextSMS')
                         ->with(array(
                                    "username"      => $this->username,
                                    "password"      => $this->password,
                                    "mobilenumbers" => $this->normalizedPhoneNumber,
                                    "message"       => $this->nonUnicodeString,
                                    "senderID"      => $this->senderId
                                )
            );

        $this->client->sendSms($this->phoneNumber, $this->nonUnicodeString);
    }

    public function testSendingUnicodeMessageCallsSendUnicodeSMSSoapMethod()
    {
        $this->clientMock->expects($this->once())
                         ->method('SendUnicodeSMS')
                         ->with(array(
                                    "username"      => $this->username,
                                    "password"      => $this->password,
                                    "mobilenumbers" => $this->normalizedPhoneNumber,
                                    "message"       => $this->unicodeString,
                                    "senderID"      => $this->senderId
                                )
            );

        $this->client->sendSms($this->phoneNumber, $this->unicodeString);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client($this->username, $this->password, $this->senderId, $this->clientMock);
    }

    protected static function getClientMethod($name)
    {
        $class  = new ReflectionClass('Namshi\SMSCountry\Client');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}