<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

/**
 * Class GetWarehousesListTest
 * Integration test for \SergeyNezbritskiy\NovaPoshta\Models\Address
 *
 * @see Address::getWarehouses
 */
class GetWarehousesListTest extends TestCase
{
    use UsesConnectionTrait;

    private Address $model;

    protected function setUp(): void
    {
        $connection = $this->getConnection();
        $this->model = new Address($connection);
    }


    /**
     * @return void
     * @throws NovaPoshtaApiException
     */
    public function testGetWarehouses(): void
    {
        $actualResult = $this->model->getWarehouses([], 1, 10);
        $this->assertIsArray($actualResult);
        $this->assertIsWarehouse(array_shift($actualResult));
    }

    /**
     * @param array $warehouse
     * @return void
     */
    private function assertIsWarehouse(array $warehouse): void
    {
        $this->assertArrayHasKey('Ref', $warehouse);
        $this->assertArrayHasKey('Description', $warehouse);
        $this->assertArrayHasKey('CityRef', $warehouse);
        $this->assertArrayHasKey('WarehouseStatus', $warehouse);
        $this->assertArrayHasKey('CategoryOfWarehouse', $warehouse);
        $this->assertArrayHasKey('TypeOfWarehouse', $warehouse);
    }
}
