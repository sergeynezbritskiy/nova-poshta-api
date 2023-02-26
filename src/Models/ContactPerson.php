<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Models;

use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\ModelInterface;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

class ContactPerson implements ModelInterface
{
    private const MODEL_NAME = 'ContactPerson';

    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a39040c4-8512-11ec-8ced-005056b2dbe1/method/a3a25bda-8512-11ec-8ced-005056b2dbe1
     * @param string $ref
     * @param array $counterparty
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function save(string $ref, array $counterparty): array
    {
        $params = [
            'CounterpartyRef' => $ref,
            'FirstName' => $counterparty['FirstName'],
            'MiddleName' => $counterparty['MiddleName'],
            'LastName' => $counterparty['LastName'],
            'Phone' => $counterparty['Phone'],
            'Email' => $counterparty['Email'],
        ];
        $result = $this->connection->post(self::MODEL_NAME, 'save', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a39040c4-8512-11ec-8ced-005056b2dbe1/method/a3c5a577-8512-11ec-8ced-005056b2dbe1
     * @param string $ref
     * @param array $counterparty
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function update(string $ref, array $counterparty): array
    {
        $params = [
            'CounterpartyRef' => $ref,
            'Ref' => $counterparty['Ref'],
            'FirstName' => $counterparty['FirstName'],
            'MiddleName' => $counterparty['MiddleName'],
            'LastName' => $counterparty['LastName'],
            'Phone' => $counterparty['Phone'],
            'Email' => $counterparty['Email'],
        ];
        $result = $this->connection->post(self::MODEL_NAME, 'update', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a39040c4-8512-11ec-8ced-005056b2dbe1/method/a3ea91c8-8512-11ec-8ced-005056b2dbe1
     * @param string $ref
     * @return void
     * @throws NovaPoshtaApiException
     */
    public function delete(string $ref): void
    {
        $this->connection->post(self::MODEL_NAME, 'delete', ['Ref' => $ref]);
    }
}
