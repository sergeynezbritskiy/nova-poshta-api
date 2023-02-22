<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetSettlementsTest extends TestCase
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
    public function testGetSettlements(): void
    {
        $actualResult = $this->model->getSettlements([], true, 1, 10);
        $this->assertNotEmpty($actualResult);
        $this->assertIsSettlement(array_shift($actualResult));
    }

    /**
     * @param array $settlement
     * @return void
     */
    private function assertIsSettlement(array $settlement): void
    {
        $this->assertArrayHasKey('Ref', $settlement);
        $this->assertArrayHasKey('SettlementType', $settlement);
    }
}
