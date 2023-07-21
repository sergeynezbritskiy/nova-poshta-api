<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests;

interface ConstantsInterface
{
    public const CITY_REF_KHARKIV = 'db5c88e0-391c-11dd-90d9-001a92567626';
    public const CITY_REF_KYIV = '8d5a980d-391c-11dd-90d9-001a92567626';

    /**
     * Counterparty Ref
     */
    public const COUNTERPARTY_REF = '4d062b9d-b88e-11ed-a60f-48df37b921db';

    /**
     * Вулиця Тимурiвцiв
     */
    public const STREET_REF = 'a7503d2c-8c06-11de-9467-001ec9d9f7b7';

    /**
     * Aдреса: вул. Тимурівців вул. 101a кв. 94 This address is for testing (created)
     */
    public const ADDRESS_REF_KHARKIV = '42f70137-25ae-11ee-a60f-48df37b921db';

    /**
     * Aдреса: вул. Хрещатик
     */
    public const ADDRESS_REF_KYIV = 'ed92c4be-25b3-11ee-a60f-48df37b921db';

    /**
     * Вулиця Хрещатик
     */
    public const KHRESHCHATYK_STREET_REF = '0f0d85b0-4143-11dd-9198-001d60451983';

    /**
     * Ідентифікатор типу відправлення Шина R-13, з довідника Види шин та дисків
     *
     * @see \SergeyNezbritskiy\NovaPoshta\Models\Common::getTiresWheelsList
     */
    public const CARGO_TYPE_TIRES_WHEELS_DESCRIPTION = 'd7c456cf-aa8b-11e3-9fa0-0050568002cf';

    /**
     * @see \SergeyNezbritskiy\NovaPoshta\Models\Common::getPalletsList()
     */
    public const CARGO_TYPE_PALLETS_DESCRIPTION = '627b0c26-d110-11dd-8c0d-001d92f78697';

    /**
     * @see \SergeyNezbritskiy\NovaPoshta\Models\Common::getCargoDescriptionList()
     */
    public const CARGO_TYPE_CARGO_DESCRIPTION = '223a10d1-33f5-11e3-b441-0050568002cf';
}
