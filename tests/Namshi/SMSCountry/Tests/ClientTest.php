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

    public function testSendingNonUnicodeMessageCallsSendTextSmsSoapMethod()
    {
        $textResponse = (object)array("SendTextSMSResponse" => true);

        $this->clientMock->expects($this->once())
                         ->method('SendTextSMS')
                         ->with(array(
                                    "username"      => $this->username,
                                    "password"      => $this->password,
                                    "mobilenumbers" => $this->normalizedPhoneNumber,
                                    "message"       => $this->nonUnicodeString,
                                    "senderID"      => $this->senderId
                                )
            )
                         ->will($this->returnValue($textResponse));

        $this->client->sendSms($this->phoneNumber, $this->nonUnicodeString);
    }

    public function testSendingUnicodeMessageCallsSendUnicodeSMSSoapMethod()
    {
        $unicodeResponse = (object)array("SendUnicodeSMSResponse" => true);

        $this->clientMock->expects($this->once())
                         ->method('SendUnicodeSMS')
                         ->with(array(
                                    "username"      => $this->username,
                                    "password"      => $this->password,
                                    "mobilenumbers" => $this->normalizedPhoneNumber,
                                    "message"       => $this->unicodeString,
                                    "senderID"      => $this->senderId
                                )
            )
                         ->will($this->returnValue($unicodeResponse));

        $this->client->sendSms($this->phoneNumber, $this->unicodeString);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client($this->username, $this->password, $this->senderId, $this->clientMock);
    }
}
