<?php

namespace Omnipay\Sofort\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://api.sofort.com/api/xml';

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getProjectId()
    {
        return $this->getParameter('projectId');
    }

    public function setProjectId($value)
    {
        return $this->setParameter('projectId', $value);
    }

    public function getCountry()
    {
        return $this->getParameter('country');
    }

    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient
            ->request('POST', $this->getEndpoint(), [
                'Authorization' => 'Basic '.base64_encode($this->getUsername().':'.$this->getPassword()),
                'Content-Type' => 'application/xml',
                'Accept' => 'application/xml'
            ], $data->asXML());

        $result = simplexml_load_string($httpResponse->getBody()->getContents());

        return $this->createResponse($result);
    }

    abstract protected function createResponse($httpResponse);

    protected function getEndpoint()
    {
        return $this->endpoint;
    }
}
