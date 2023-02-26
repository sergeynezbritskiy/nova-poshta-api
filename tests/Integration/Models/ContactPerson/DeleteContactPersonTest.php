<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Integration\Models\ContactPerson;

use Exception;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\NovaPoshta\Models\ContactPerson;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;
use SergeyNezbritskiy\NovaPoshta\Tests\UsesConnectionTrait;

use function count;

class DeleteContactPersonTest extends TestCase
{
    use UsesConnectionTrait;

    /**
     * Counterparty Ref
     */
    private const COUNTERPARTY_REF = '98d078a0-e096-11e6-8ba8-005056881c6b';

    private ContactPerson $model;
    private Counterparty $counterpartyModel;

    protected function setUp(): void
    {
        $connection = $this->getConnection();
        $this->model = new ContactPerson($connection);
        $this->counterpartyModel = new Counterparty($connection);
    }

    /**
     * @return void
     * @throws NovaPoshtaApiException
     * @throws Exception
     */
    public function testDeleteNotExistingContactPerson(): void
    {
        $this->model->delete('not-existing-contact-person-ref');
        $this->assertTrue(true, 'No exception has been thrown, we are good');
    }
}
