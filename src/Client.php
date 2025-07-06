<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta;

use GuzzleHttp\Client as HttpClient;
use SergeyNezbritskiy\NovaPoshta\Models\Address;
use SergeyNezbritskiy\NovaPoshta\Models\Common;
use SergeyNezbritskiy\NovaPoshta\Models\ContactPerson;
use SergeyNezbritskiy\NovaPoshta\Models\Counterparty;
use SergeyNezbritskiy\NovaPoshta\Models\InternetDocument;

/**
 * Class Client
 *
 * Class-connector with NovaPoshta API
 *
 * @see      https://developers.novaposhta.ua/documentation
 */
readonly class Client
{
    public Address $address;
    public Counterparty $counterparty;
    public ContactPerson $contactPerson;
    public Common $common;
    public InternetDocument $internetDocument;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $connection = new Connection($apiKey, new HttpClient());
        $this->address = new Address($connection);
        $this->counterparty = new Counterparty($connection);
        $this->contactPerson = new ContactPerson($connection);
        $this->common = new Common($connection);
        $this->internetDocument = new InternetDocument($connection);
    }
}
