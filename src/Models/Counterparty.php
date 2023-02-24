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
     * @param array $counterparty Array containing the necessary params.
     *    $counterparty = [
     *      'FirstName'             => (string) First name. Required.
     *      'MiddleName'            => (string) Middle name. Required.
     *      'LastName'              => (string) Last name. Required.
     *      'Phone'                 => (string) Phone number. Required.
     *      'Email'                 => (string) Email. Required.
     *      'CounterpartyProperty'  => (string) Counterparty property. Required.
     *    ]
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function savePrivatePerson(array $counterparty): array
    {
        $counterparty['CounterpartyType'] = 'PrivatePerson';
        $result = $this->connection->post(self::MODEL_NAME, 'save', $counterparty);
        return array_shift($result);
    }

    /**
     * @param array $counterparty Array containing the necessary params.
     *    $counterparty = [
     *      'EDRPOU'                 => (string) EDRPOU. Required.
     *      'CounterpartyProperty'  => (string) Counterparty property. Optional.
     *    ]
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function saveOrganisation(array $counterparty): array
    {
        $counterparty['CounterpartyType'] = 'Organization';
        $result = $this->connection->post(self::MODEL_NAME, 'save', $counterparty);
        return array_shift($result);
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
