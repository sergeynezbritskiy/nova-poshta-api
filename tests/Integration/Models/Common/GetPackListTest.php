<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\Common;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Common;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\AssertEntityByPropertiesTrait;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class GetPackListTest extends TestCase
{
    use AssertEntityByPropertiesTrait;
    use UsesConnectionTrait;

    private Common $model;

    protected function setUp(): void
    {
        $connection = $this->getConnection();
        $this->model = new Common($connection);
    }

    /**
     * @return void
     * @throws NovaPoshtaApiException
     */
    public function testGetPackList(): void
    {
        $actualResult = $this->model->getPackList();
        $this->assertNotEmpty($actualResult);
        $entity = array_shift($actualResult);
        $expectedKeys = [
            'Ref',
            'Description',
            'DescriptionRu',
            'Length',
            'Width',
            'Height',
            'VolumetricWeight',
            'TypeOfPacking',
            'PackagingForPlace',

        ];
        $this->assertEntity($entity, $expectedKeys);
    }
}
