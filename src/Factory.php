<?php

namespace Guilty\Apsis;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class Factory.
 *
 * @method \Guilty\Apsis\Services\Account account()
 * @method \Guilty\Apsis\Services\event event()
 */
class Factory
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Factory constructor.
     *
     * @param string $apiKey APSIS API Key
     * @param \GuzzleHttp\ClientInterface|null $client If you wish to override the client
     */
    public function __construct($apiKey, ClientInterface $client = null)
    {
        $this->client = $client ?: $this->makeDefaultClient($apiKey);
    }

    /**
     * @param string $apiKey
     * @param null|\GuzzleHttp\ClientInterface $client
     * @return \Guilty\Apsis\Factory
     */
    public static function create($apiKey, $client = null)
    {
        return new static($apiKey, $client);
    }


    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return \Guilty\Apsis\Services\Service
     */
    public function __call($name, $arguments)
    {
        $resource = 'Guilty\\Apsis\\Services\\' . ucfirst($name);
        return new $resource($this->client);
    }

    public function makeDefaultClient($apiKey)
    {
        return new Client(
            [
                'base_uri' => 'http://se.api.anpdm.com/',
                'headers' => ['Accept' => 'application/json'],
                'auth' => [$apiKey, '', 'basic']
            ]
        );
    }
}