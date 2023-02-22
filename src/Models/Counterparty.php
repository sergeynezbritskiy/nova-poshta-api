<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Models;

use RuntimeException;
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
        return $this->connection->post('Counterparty', 'getCounterpartyAddresses', $params);
    }
}
