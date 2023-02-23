<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Counterparty;

use Exception;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class SaveTest extends TestCase
{
    use UsesConnectionTrait;

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
    public function testCounterpartyCrud(): void
    {
        $sfx = $this->randomString(5);
        $counterparty = [
            'FirstName' => 'Іван' . $sfx,
            'MiddleName' => 'Іванович' . $sfx,
            'LastName' => 'Іванов' . $sfx,
            'Phone' => rand(380000000000, 380000999999),
            'Email' => 'ivan.ivanov@nova-poshta.test',
            'CounterpartyType' => 'PrivatePerson',
            'CounterpartyProperty' => 'Recipient',
        ];
        $actualResult = $this->model->save($counterparty);
        $this->assertIsCounterparty($actualResult);
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

    /**
     * @throws Exception
     */
    private function randomString($length = 10): string
    {
        $characters = 'абвгґдеєжзиіїйклмнопрстуфхцчшщьюяАБВГҐДЕЄЖЗИІЇЙКЛМНОПРСТУФХЦЧШЩЬЮЯ';
        $charactersLength = mb_strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $symbolPosition = random_int(0, $charactersLength - 1);
            $randomString .= mb_substr($characters, $symbolPosition, 1);
        }
        return $randomString;
    }
}
