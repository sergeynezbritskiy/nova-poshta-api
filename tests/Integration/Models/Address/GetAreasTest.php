<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Address;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetAreasTest extends TestCase
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
    public function testGetAreas(): void
    {
        $actualResult = $this->model->getAreas();
        $this->assertNotEmpty($actualResult);
        $this->assertIsArea(array_shift($actualResult));
    }

    /**
     * @param array $area
     * @return void
     */
    private function assertIsArea(array $area): void
    {
        $this->assertCount(4, $area);
        $this->assertArrayHasKey('Ref', $area);
        $this->assertArrayHasKey('AreasCenter', $area);
        $this->assertArrayHasKey('DescriptionRu', $area);
        $this->assertArrayHasKey('Description', $area);
    }
}
