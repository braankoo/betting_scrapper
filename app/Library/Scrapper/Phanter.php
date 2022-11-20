<?php

namespace App\Library\Scrapper;

use Symfony\Component\Panther\Client;


/**
 *
 */
class Phanter implements ScrapperInterface {

    /**
     * @var \App\Library\Scrapper\Phanter|null
     */
    private static ?Phanter $instance = null;
    /**
     * @var \Symfony\Component\Panther\Client
     */
    private Client $client;

    /**
     * @return \Symfony\Component\Panther\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return array
     */
    private function getDefaultOptions(): array
    {
        return [
            'scheme'       => 'http',
            'host'         => '127.0.0.1',
            'port'         => $this->getUnusedPort(),
            'path'         => '/status',
            'capabilities' => [],
        ];
    }

    /**
     * @return mixed
     */
    private function getUnusedPort(): mixed
    {
        $address = '127.0.0.1';
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($sock, $address);
        socket_getsockname($sock, $address, $port);
        socket_close($sock);

        return $port;
    }


    /**
     *
     */
    public
    function __construct()
    {

        $this->client = Client::createChromeClient(null, [
            '--headless',
            '--window-size=1200,1100',
            '--no-sandbox',
            '--disable-gpu'
        ], $this->getDefaultOptions());
    }

    /**
     * @return \App\Library\Scrapper\Phanter|null
     */
    public
    static function getInstance(): ?Phanter
    {
        if (self::$instance === null)
        {
            self::$instance = new Phanter();
        }

        return self::$instance;

    }
}
