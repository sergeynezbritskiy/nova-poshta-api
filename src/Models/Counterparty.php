<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Models;

use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\ModelInterface;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

class Counterparty implements ModelInterface
{
    private const MODEL_NAME = 'Counterparty';

    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param string $phone
     * @param string $email
     * @param string $type
     * @param string $property
     * @return array
     * @throws NovaPoshtaApiException
     * phpcs:disable Generic.Files.LineLength.TooLong
     */
    public function save(string $firstName, string $middleName, string $lastName, string $phone, string $email, string $type, string $property): array
    {
        $params = [
            'FirstName' => $firstName,
            'MiddleName' => $middleName,
            'LastName' => $lastName,
            'Phone' => $phone,
            'Email' => $email,
            'CounterpartyType' => $type,
            'CounterpartyProperty' => $property,
        ];
        return $this->connection->post(self::MODEL_NAME, 'save', $params);
    }

    /**
     * @param string $counterpartyRef
     * @param string $counterpartyProperty
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getCounterpartyAddresses(string $counterpartyRef, string $counterpartyProperty): array
    {
        $params = [
            'Ref' => $counterpartyRef,
            'CounterpartyProperty' => $counterpartyProperty,
        ];
        return $this->connection->post(self::MODEL_NAME, 'getCounterpartyAddresses', $params);
    }
}
