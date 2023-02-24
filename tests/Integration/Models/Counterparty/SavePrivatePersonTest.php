<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\Tests\Integration\Models\Counterparty;

use Exception;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class SavePrivatePersonTest extends TestCase
{
    use UsesConnectionTrait;

    /**
     * Kharkiv city ref
     */
    private const CITY_REF = 'db5c88e0-391c-11dd-90d9-001a92567626';

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
        $sfx = $this->randomString(5);
        $counterparty = [
            'FirstName' => 'Іван' . $sfx,
            'MiddleName' => 'Іванович' . $sfx,
            'LastName' => 'Іванов' . $sfx,
            'Phone' => rand(380000000000, 380000999999),
            'Email' => 'ivan.ivanov@nova-poshta.test',
            'CounterpartyProperty' => 'Recipient',
        ];

        //create counterparty
        $actualResult = $this->model->savePrivatePerson($counterparty);
        $this->assertIsCounterparty($actualResult);

        //update counterparty
        $counterparty['Ref'] = $actualResult['Ref'];
        $counterparty['MiddleName'] = 'Петрович' . $sfx;
        $counterparty['CityRef'] = self::CITY_REF;

        $actualResult = $this->model->updatePrivatePerson($counterparty);
        $this->assertSame($counterparty['MiddleName'], $actualResult['MiddleName']);

        //get counterparty options
        $counterpartyOptions = $this->model->getCounterpartyOptions($counterparty['Ref']);
        $this->assertIsCounterpartyOptions($counterpartyOptions);

        //delete counterparty
        $this->expectExceptionMessage('Counterparty PrivatePerson can\'t be deleted');
        $this->model->delete($counterparty['Ref']);
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
     * @param array $counterpartyOptions
     * @return void
     */
    private function assertIsCounterpartyOptions(array $counterpartyOptions): void
    {
        $this->assertArrayHasKey('Debtor', $counterpartyOptions);
        $this->assertArrayHasKey('DebtorParams', $counterpartyOptions);
        $this->assertArrayHasKey('SecurePayment', $counterpartyOptions);
        $this->assertArrayHasKey('MainCounterparty', $counterpartyOptions);
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
