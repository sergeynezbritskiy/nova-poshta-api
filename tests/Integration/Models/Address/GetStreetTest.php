<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetStreetTest extends TestCase
{
    use UsesConnectionTrait;

    /**
     * Kharkiv city ref
     */
    private const CITY_REF = 'db5c88e0-391c-11dd-90d9-001a92567626';
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
    public function testGetStreet(): void
    {
        $actualResult = $this->model->getStreet(self::CITY_REF, 'Черниш', 1, 10);
        $this->assertIsArray($actualResult);
        $this->assertIsStreet(array_shift($actualResult));
    }

    /**
     * @param array $street
     * @return void
     */
    private function assertIsStreet(array $street): void
    {
        $this->assertArrayHasKey('Description', $street);
        $this->assertArrayHasKey('Ref', $street);
        $this->assertArrayHasKey('StreetsTypeRef', $street);
        $this->assertArrayHasKey('StreetsType', $street);
    }
}
