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
     * @return void
     * @throws NovaPoshtaApiException
     */
    protected function tearDown(): void
    {
        foreach ($this->getAllDocuments() as $document) {
            $this->deleteDocument($document['Ref']);
        }
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
            'ServiceType' => InternetDocument::SERVICE_TYPE_DOORS_DOORS,
            'PayerType' => InternetDocument::PAYER_TYPE_RECIPIENT,
            'PaymentMethod' => InternetDocument::PAYMENT_TYPE_CASH,
            'Description' => 'Це тестове замовлення, не треба його обробляти'
        ];

        $actualResult = $this->model->save($params);
        $this->assertNotEmpty($actualResult['Ref']);

        $params['PayerType'] = InternetDocument::PAYER_TYPE_SENDER;
        $params['Ref'] = $actualResult['Ref'];

        $this->gulp();

        $actualResult = $this->model->update($params);

        $this->gulp();

        $document = $this->getDocumentByRef($actualResult['Ref']);
        $this->assertSame($params['PayerType'], $document['PayerType']);

        $this->gulp();

        //delete document
        $this->deleteDocument($actualResult['Ref']);

        $this->gulp();

        $this->assertDocumentDeleted($actualResult['Ref']);
    }

    /**
     * @param string $ref
     * @param int $attempt
     * @return void
     * @throws NovaPoshtaApiException
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    private function deleteDocument(string $ref, int $attempt = 1): void
    {
        try {
            $this->model->delete($ref);
        } catch (NovaPoshtaApiException $e) {
            $docNotCreatedYet = str_contains($e->getMessage(), 'No document changed DeletionMark');
            if (!$docNotCreatedYet) {
                throw $e;
            }
            $attemptsNotExceeded = $attempt <= 3;
            if ($attemptsNotExceeded) {
                printf(PHP_EOL . 'Attempt %d to delete document failed.' . PHP_EOL, $attempt);
                sleep(5 * $attempt);
                $this->deleteDocument($ref, ++$attempt);
            } else {
                throw $e;
            }
        }
    }

    /**
     * @param string $ref
     * @return void
     * @throws NovaPoshtaApiException
     */
    private function assertDocumentDeleted(string $ref): void
    {
        if ($this->getDocumentByRef($ref)) {
            $this->fail('Failed to delete document.');
        }
        $this->assertTrue(true, 'Just to suppress error that method doesn\'t do any assertions');
    }

    /**
     * @param string $ref
     * @return array|null
     * @throws NovaPoshtaApiException
     */
    public function getDocumentByRef(string $ref): ?array
    {
        $documents = $this->getAllDocuments();
        foreach ($documents as $document) {
            if ($document['Ref'] === $ref) {
                return $document;
            }
        }
        return null;
    }

    /**
     * @return array
     * @throws NovaPoshtaApiException
     */
    private function getAllDocuments(): array
    {
        return $this->model->getDocumentList([
            'DateTimeFrom' => date('d.m.Y', strtotime('-2 days')),
            'DateTimeTo' => date('d.m.Y', strtotime('+2 days')),
            'GetFullList' => 1,
            'DateTime' => date('d.m.Y'),
        ], 1);
    }

    /**
     * @return void
     */
    private function gulp(): void
    {
        $useGulp = getenv('USE_GULP');

        if ($useGulp) {
            sleep(5);
        }
    }
}
