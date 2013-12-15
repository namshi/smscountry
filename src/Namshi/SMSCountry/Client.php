<?php
namespace Namshi\SMSCountry;

class Client
{
    protected $username, $password, $senderId, $serviceWsdlUrl, $soapClient;

    /**
     * @param $username
     * @param $password
     * @param $senderId
     * @param $serviceWsdlUrl
     */
    public function __construct($username, $password, $senderId, $serviceWsdlUrl)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setSenderId($senderId);
        $this->setServiceWsdlUrl($serviceWsdlUrl);
    }

    public function sendSms($phoneNumber, $body)
    {
        $response = $this->getSoapClient()->SendTextSMS(
            array(
                'username'      => $this->getUsername(),
                'password'      => $this->getPassword(),
                'mobilenumbers' => $phoneNumber,
                'message'       => $body,
                'senderID'      => $this->getSenderId()
            )
        );

        return is_int($response->SendTextSMSResult);
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $serviceWsdlUrl
     */
    public function setServiceWsdlUrl($serviceWsdlUrl)
    {
        $this->serviceWsdlUrl = $serviceWsdlUrl;
        $this->setSoapClient(new \SoapClient($serviceWsdlUrl));
    }

    /**
     * @return mixed
     */
    public function getServiceWsdlUrl()
    {
        return $this->serviceWsdlUrl;
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
     * @param mixed $soapClient
     */
    protected function setSoapClient($soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * @return mixed
     */
    public function getSoapClient()
    {
        return $this->soapClient;
    }
}