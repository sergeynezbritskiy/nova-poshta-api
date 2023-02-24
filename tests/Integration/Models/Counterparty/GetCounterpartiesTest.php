<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Counterparty;

use Exception;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetCounterpartiesTest extends TestCase
{
    use UsesConnectionTrait;


    /**
     * Counterparty Ref
     */
    private const COUNTERPARTY_REF = '98d078a0-e096-11e6-8ba8-005056881c6b';

    private Counterparty $model;

    protected function setUp(): void
    {
        $connection = $this->getConnection();
        $this->model = new Counterparty($connection);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCounterpartyPrivatePersonCrud(): void
    {
        $actualResult = $this->model->getCounterparties(Counterparty::COUNTERPARTY_PROPERTY_SENDER);
        $this->assertNotEmpty($actualResult);
        $this->assertIsCounterparty(array_shift($actualResult));
    }

    /**
     * @param array $counterparty
     * @return void
     */
    private function assertIsCounterparty(array $counterparty): void
    {
        $this->assertArrayHasKey('Ref', $counterparty);
        $this->assertArrayHasKey('Description', $counterparty);
        $this->assertArrayHasKey('FirstName', $counterparty);
        $this->assertArrayHasKey('LastName', $counterparty);
        $this->assertArrayHasKey('Counterparty', $counterparty);
        $this->assertArrayHasKey('EDRPOU', $counterparty);
        $this->assertArrayHasKey('CounterpartyType', $counterparty);
    }
}
