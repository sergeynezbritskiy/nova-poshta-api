<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Client;
use SergeyNezbritskiy\NovaPoshta\Models\Address;

/**
 * Class ClientTest
 * Unit test for \SergeyNezbritskiy\NovaPoshta\Client
 * @see Client
 */
class ClientTest extends TestCase
{
    private Client $object;

    protected function setUp(): void
    {
        $this->object = new Client('some-key');
    }

    public function testAddressModelProperty(): void
    {
        $addressModel = $this->object->address;
        $this->assertInstanceOf(Address::class, $addressModel);
    }

    public function testNotSupportedProperty(): void
    {
        $property = 'someNotSupportedModel';
        $this->expectExceptionMessage('Model `someNotSupportedModel` not supported by Nova Poshta API Client');
        $this->expectException(Exception::class);
        /** @phpstan-ignore-next-line */
        $this->object->$property;
    }
}
