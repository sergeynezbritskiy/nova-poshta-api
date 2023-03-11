<?php

/**
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Models;

use DateTime;
use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\ModelInterface;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

class InternetDocument implements ModelInterface
{
    public const CARGO_TYPE_CARGO = 'Cargo';
    public const CARGO_TYPE_DOCUMENTS = 'Documents';
    public const CARGO_TYPE_TIRES_WHEELS = 'TiresWheels';
    public const CARGO_TYPE_PALLET = 'Pallet';

    private const MODEL_NAME = 'InternetDocument';
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
     *        ]
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
     *    ]
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function getDocumentPrice(array $params): array
    {
        $result = $this->connection->post(self::MODEL_NAME, 'getDocumentPrice', $params);
        return array_shift($result);
    }

    /**
     * @throws NovaPoshtaApiException
     */
    public function getDocumentDeliveryDate(DateTime $date, string $serviceType, string $citySrc, string $cityDst): array
    {
        $params = [
            'DateTime' => $date->format('d.m.Y'),
            'ServiceType' => $serviceType,
            'CitySender' => $citySrc,
            'CityRecipient' => $cityDst
        ];
        $result = $this->connection->post(self::MODEL_NAME, 'getDocumentDeliveryDate', $params);
        return array_shift($result)['DeliveryDate'];
    }
}
