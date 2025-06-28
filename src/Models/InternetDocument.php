<?php

/**
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Models;

use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\ModelInterface;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

class InternetDocument implements ModelInterface
{
    public const string CARGO_TYPE_CARGO = 'Cargo';
    public const string CARGO_TYPE_DOCUMENTS = 'Documents';
    public const string CARGO_TYPE_TIRES_WHEELS = 'TiresWheels';
    public const string CARGO_TYPE_PALLET = 'Pallet';

    public const string SERVICE_TYPE_DOORS_DOORS = 'DoorsDoors';
    public const string SERVICE_TYPE_DOORS_WAREHOUSE = 'DoorsWarehouse';
    public const string SERVICE_TYPE_WAREHOUSE_DOORS = 'WarehouseDoors';
    public const string SERVICE_TYPE_WAREHOUSE_WAREHOUSE = 'WarehouseWarehouse';

    public const string PAYER_TYPE_SENDER = 'Sender';
    public const string PAYER_TYPE_RECIPIENT = 'Recipient';
    public const string PAYER_TYPE_THIRD_PERSON = 'ThirdPerson';

    public const string PAYMENT_TYPE_CASH = 'Cash';
    public const string PAYMENT_TYPE_NON_CASH = 'NonCash';

    private const string MODEL_NAME = 'InternetDocument';

    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a91f115b-8512-11ec-8ced-005056b2dbe1
     * @see \SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\InternetDocument\GetDocumentPriceTest for more cases
     * @param array $params
     *    $params = [
     *        'CitySender'          => (string) City ref. Required
     *        'CityRecipient'       => (string) City ref. Required
     *        'Weight'              => (string) Minimal value - 0.1. Required
     *        'ServiceTYpe'         => (string) Optional
     *        'Cost'                => (float)  Optional, default - 300.00
     *        'CargoType'           => (string) Cargo type. see self::CARGO_TYPE_* constants, Optional
     *        'CargoDetails'        => [
     *            [
     *                'CargoDescription' => (string),
     *                'Amount' => (float)
     *            ],
     *            ...
     *        ],
     *        'RedeliveryCalculate' => [ Back delivery. Optional
     *            [
     *                'CargoType' => (string), e.g. Money
     *                'Amount' => (float)
     *            ],
     *            ...
     *        ],
     *        'OptionsSeat' => [
     *            'weight' => (float), Required.
     *            'volumetricWidth' => (float), Required.
     *            'volumetricLength' => (float), Required.
     *            'volumetricHeight' => (float), Required.
     *            'packRef' => (string), Optional.
     *        ],
     *        'SeatsAmount'         => (int) Optional
     *        'PackCount'           => (int) Optional
     *        'CargoDescription'    => (string) Cargo type. see self::CARGO_TYPE_* constants, Optional
     *        'PackCount'           => (string) The amount of packing, Optional
     *        'PackRef'             => (string) Packing identifier (REF). Optional
     *        'Amount'              => (int) Amount of back delivery. Optional
     *    ];
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getDocumentPrice(array $params): array
    {
        $result = $this->connection->post(self::MODEL_NAME, 'getDocumentPrice', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a941c714-8512-11ec-8ced-005056b2dbe1
     * @see \SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\InternetDocument\GetDocumentDeliveryDateTest
     * @param array $params
     *         $params = [
     *              'DateTime'      => (string), Document creation date, format `d.m.Y`. Optional.
     *              'ServiceType'   => (string), Required.
     *              'CitySender'    => (string), city ref. Required.
     *              'CityRecipient' => (string), city ref. Required.
     *          ];
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getDocumentDeliveryDate(array $params): array
    {
        $result = $this->connection->post(self::MODEL_NAME, 'getDocumentDeliveryDate', $params);
        return array_shift($result)['DeliveryDate'];
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a9d22b34-8512-11ec-8ced-005056b2dbe1
     * @param array $params
     * @param int $page
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getDocumentList(array $params, int $page = 0): array
    {
        if ($page !== 0) {
            $params['Page'] = $page;
        }
        return $this->connection->post(self::MODEL_NAME, 'getDocumentList', $params);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a965630e-8512-11ec-8ced-005056b2dbe1
     * @param array $params
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function save(array $params): array
    {
        $result = $this->connection->post(self::MODEL_NAME, 'save', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a98a4354-8512-11ec-8ced-005056b2dbe1
     * @param array $params
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function update(array $params): array
    {
        $result = $this->connection->post(self::MODEL_NAME, 'update', $params);
        return array_shift($result);
    }

    /**
     * @see https://developers.novaposhta.ua/view/model/a90d323c-8512-11ec-8ced-005056b2dbe1/method/a965630e-8512-11ec-8ced-005056b2dbe1
     * @param string $documentRef
     * @return void
     * @throws NovaPoshtaApiException
     */
    public function delete(string $documentRef): void
    {
        $this->connection->post(self::MODEL_NAME, 'delete', ['DocumentRefs' => $documentRef]);
    }
}
