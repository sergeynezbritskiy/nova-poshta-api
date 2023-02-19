<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta;

use PHPUnit\Logging\Exception;
use SergeyNezbritskiy\NovaPoshta\Models\Address;

/**
 * Class Client
 *
 * Class-connector with NovaPoshta API
 *
 * @property Address $address
 * @see      https://developers.novaposhta.ua/documentation
 */
class Client
{
    private const MODELS_MAP = [
        'address' => Address::class
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
            $this->connection = new Connection($this->apiKey);
        }
        return $this->connection;
    }
}
