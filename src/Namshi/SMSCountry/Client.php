<?php
namespace Namshi\SMSCountry;

use \SoapClient;

class Client
{
    /**
     * @string username
     */
    protected $username;

    /**
     * @string  password
     */
    protected $password;

    /**
     * @string senderId
     */
    protected $senderId;

    /**
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * @var array of stripped chars on phone number
     */
    protected $phoneNumberStrippedChars = array(' ', '_', '-', '[', ']', '(', ')', '+');

    /**
     * @param $username
     * @param $password
     * @param $senderId
     * @param $soapClient
     */
    public function __construct($username, $password, $senderId, SoapClient $soapClient)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setSenderId($senderId);
        $this->setSoapClient($soapClient);
    }

    /**
     * @param $phoneNumber
     * @param $body
     *
     * @return bool
     */
    public function sendSms($phoneNumber, $body)
    {
        $normalizedPhone = $this->normalizePhoneNumber($phoneNumber);
        $response        = $this->getSoapClient()->SendUnicodeSMS(
            array(
                'username'      => $this->getUsername(),
                'password'      => $this->getPassword(),
                'mobilenumbers' => $normalizedPhone,
                'message'       => $body,
                'senderID'      => $this->getSenderId()
            )
        );

        return $response;
    }

    /**
     * Normalize Phone by removing unnecessary chars
     *
     * @param $phone
     *
     * @return string
     */
    protected function normalizePhoneNumber($phone)
    {
        return str_replace($this->phoneNumberStrippedChars, '', $phone);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return string
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param SoapClient $soapClient
     */
    protected function setSoapClient(SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * @return SoapClient
     */
    public function getSoapClient()
    {
        return $this->soapClient;
    }
}
