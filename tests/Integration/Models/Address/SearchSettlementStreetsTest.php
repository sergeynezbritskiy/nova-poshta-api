<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class SearchSettlementStreetsTest extends TestCase
{
    use UsesConnectionTrait;

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
    public function testSearchSettlementStreets(): void
    {
        $actualResult = $this->model->searchSettlementStreets('Чернишевського', self::CITY_REF);
        $this->assertArrayHasKey('TotalCount', $actualResult);
        $this->assertArrayHasKey('Addresses', $actualResult);
    }
}
