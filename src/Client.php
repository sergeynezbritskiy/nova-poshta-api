<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta;

use AllowDynamicProperties;
use Exception;
use GuzzleHttp\Client as HttpClient;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\Models\Common;
use SergeyNezbritskiy\NovaPoshta\Models\ContactPerson;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\Models\InternetDocument;

/**
 * Class Client
 *
 * Class-connector with NovaPoshta API
 *
 * @property Address $address
 * @property Counterparty $counterparty
 * @property ContactPerson $contactPerson
 * @property ContactPerson $common
 * @property ContactPerson $internetDocument
 * @see      https://developers.novaposhta.ua/documentation
 */
#[AllowDynamicProperties] class Client
{
    private const MODELS_MAP = [
        'address' => Address::class,
        'counterparty' => Counterparty::class,
        'contactPerson' => ContactPerson::class,
        'common' => Common::class,
        'internetDocument' => InternetDocument::class,
    ];

    private string $apiKey;
    private Connection $connection;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @throws Exception
     */
    public function __get(string $property): ModelInterface
    {
        if (!array_key_exists($property, self::MODELS_MAP)) {
            throw new Exception(sprintf('Model `%s` not supported by Nova Poshta API Client', $property));
        }
        $class = self::MODELS_MAP[$property];
        $this->$property = new $class($this->getConnection());
        return $this->$property;
    }

    private function getConnection(): Connection
    {
        if (empty($this->connection)) {
            $this->connection = new Connection($this->apiKey, new HttpClient());
        }
        return $this->connection;
    }
}
