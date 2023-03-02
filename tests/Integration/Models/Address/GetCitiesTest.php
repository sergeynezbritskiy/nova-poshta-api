<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetCitiesTest extends TestCase
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
    public function testGetCities(): void
    {
        $actualResult = $this->model->getCities(1, 10);
        $this->assertIsArray($actualResult);
        $this->assertIsCity(array_shift($actualResult));
    }

    /**
     * @param array $city
     * @return void
     */
    private function assertIsCity(array $city): void
    {
        $this->assertArrayHasKey('Ref', $city);
        $this->assertArrayHasKey('Description', $city);
        $this->assertArrayHasKey('CityID', $city);
    }
}
