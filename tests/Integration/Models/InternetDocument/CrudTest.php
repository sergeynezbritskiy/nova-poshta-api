<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\InternetDocument;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\InternetDocument;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\AssertEntityByPropertiesTrait;
use SergeyNezbritskiy\NovaPoshta\Tests\ConstantsInterface;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

class CrudTest extends TestCase implements ConstantsInterface
{
    use AssertEntityByPropertiesTrait;
    use UsesConnectionTrait;

    private InternetDocument $model;

    protected function setUp(): void
    {
        date_default_timezone_set('Europe/Kyiv');
        $connection = $this->getConnection();
        $this->model = new InternetDocument($connection);
    }

    /**
     * @throws NovaPoshtaApiException
     */
    public function testCrudDocument(): void
    {

//        $counterpartyModel = new \SergeyNezbritskiy\NovaPoshta\Models\Counterparty($this->getConnection());
//        $addressModel = new \SergeyNezbritskiy\NovaPoshta\Models\Address($this->getConnection());

//        $recipient = $counterpartyModel->savePrivatePerson([
//            'FirstName' => 'Петро',
//            'MiddleName' => 'Григорович',
//            'LastName' => 'Порошенко',
//            'Phone' => 380501112233,
//            'Email' => 'pporoshenko@gmail.com',
//            'CounterpartyProperty' => Counterparty::COUNTERPARTY_PROPERTY_RECIPIENT,
//        ]); // 4d21c8c7-b88e-11ed-a60f-48df37b921db
        $recipientRef = '4d21c8c7-b88e-11ed-a60f-48df37b921db';

//        $address = $addressModel->save($recipientRef, [
//            'StreetRef' => self::KHRESHCHATYK_STREET_REF,
//            'BuildingNumber' => '20',
//            'Flat' => '12',
//        ]);
        $addressRef = 'cecaac32-25bb-11ee-a60f-48df37b921db';

//        $contactPersons = $counterpartyModel->getCounterpartyContactPersons(self::COUNTERPARTY_REF);
        $senderContactRef = '4d06cbac-b88e-11ed-a60f-48df37b921db';

//        $contactPersons = $counterpartyModel->getCounterpartyContactPersons($recipientRef);
        $recipientContactRef = '45b55250-25bb-11ee-a60f-48df37b921db';

        //create document
        $params = [
            'Sender' => self::COUNTERPARTY_REF,
            'CitySender' => self::CITY_REF_KHARKIV,
            'SenderAddress' => self::ADDRESS_REF_KHARKIV,
            'ContactSender' => $senderContactRef,
            'SendersPhone' => 380505511696,

            'Recipient' => $recipientRef,
            'CityRecipient' => self::CITY_REF_KYIV,
            'RecipientAddress' => $addressRef,
            'ContactRecipient' => $recipientContactRef,
            'RecipientsPhone' => 380505511696,

            'DateTime' => date('d.m.Y'),
            'CargoType' => InternetDocument::CARGO_TYPE_CARGO,
            'Weight' => '0.5',
            'SeatsAmount' => '1',
            'ServiceType' => 'DoorsDoors',
            'PayerType' => 'Recipient',
            'PaymentMethod' => 'Cash',
            'Description' => 'TEST, DO NOT PROCEED WITH THIS'
        ];

        $actualResult = $this->model->save($params);
        $this->assertNotEmpty($actualResult['Ref']);
        sleep(15);

        //delete document
        $this->model->delete($actualResult['Ref']);

        $documents = $this->model->getDocumentList([
            'DateTimeFrom' => date('d.m.Y', strtotime('-2 days')),
            'DateTimeTo' => date('d.m.Y', strtotime('+2 days')),
            'GetFullList' => 1,
            'DateTime' => date('d.m.Y'),
        ], 1);
        foreach ($documents as $document) {
            if ($document['Ref'] === $actualResult['Ref']) {
                $this->fail('Failed to delete document.');
            }
        }
    }
}
