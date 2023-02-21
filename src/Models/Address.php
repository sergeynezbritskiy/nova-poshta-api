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
     * @see https://developers.novaposhta.ua/view/model/a0cf0f5f-8512-11ec-8ced-005056b2dbe1/method/a0eb83ab-8512-11ec-8ced-005056b2dbe1
     * @param string $cityName
     * @param int $page
     * @param int $limit
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function searchSettlements(string $cityName, int $page = 1, int $limit = PHP_INT_MAX): array
    {
        $params = array_filter([
            'CityName' => $cityName,
            'Page' => $page,
            'Limit' => $limit,
        ]);
        $result = $this->connection->post(self::MODEL_NAME, 'searchSettlements', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a0cf0f5f-8512-11ec-8ced-005056b2dbe1/method/a1329635-8512-11ec-8ced-005056b2dbe1
     * @param string $streetName
     * @param string $settlementRef
     * @param int|null $limit
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function searchSettlementStreets(string $streetName, string $settlementRef, int $limit = null): array
    {
        $params = array_filter([
            'StreetName' => $streetName,
            'SettlementRef' => $settlementRef,
            'Limit' => $limit,
        ]);
        $result = $this->connection->post(self::MODEL_NAME, 'searchSettlementStreets', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a0cf0f5f-8512-11ec-8ced-005056b2dbe1/method/a1e6f0a7-8512-11ec-8ced-005056b2dbe1
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

    /**
     * @see https://developers.novaposhta.ua/view/model/a0cf0f5f-8512-11ec-8ced-005056b2dbe1/method/a2322f38-8512-11ec-8ced-005056b2dbe1
     * @param array $filters Available filters are: CityName, CityRef, TypeOfWarehouseRef, WarehouseId
     * @param int $page
     * @param int $limit
     * @param string $lang
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getWarehouses(array $filters = [], int $page = 1, int $limit = 1000, string $lang = 'UA'): array
    {
        $params = array_filter([
            'CityName' => $filters['CityName'] ?? null,
            'CityRef' => $filters['CityRef'] ?? null,
            'TypeOfWarehouseRef' => $filters['TypeOfWarehouseRef'] ?? null,
            'WarehouseId' => $filters['WarehouseId'] ?? null,
            'Page' => $page,
            'Limit' => $limit,
            'Language' => $lang,
        ]);
        return $this->connection->post(self::MODEL_NAME, 'getWarehouses', $params);
    }
}
