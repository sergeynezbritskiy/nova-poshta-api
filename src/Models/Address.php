<?php

namespace SergeyNezbritskiy\NovaPoshta\Models;

use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\ModelInterface;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

class Address implements ModelInterface
{
    private const MODEL_NAME = 'Address';
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string|null $search
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getCities(int $page = 1, int $limit = PHP_INT_MAX, string $search = null): array
    {
        $params = array_filter([
            'Page' => $page,
            'Limit' => $limit,
            'FindByString' => $search,
        ]);
        return $this->connection->post(self::MODEL_NAME, 'getCities', $params);
    }
}
