<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Connection
 */
class Connection
{
    private const API_URI = 'https://api.novaposhta.ua/v2.0/json/';
    private string $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $model
     * @param string $method
     * @param array $params
     * @return array
     * @throws NovaPoshtaApiException
     */
    public function post(string $model, string $method, array $params = []): array
    {
        try {
            $request = [
                'apiKey' => $this->apiKey,
                'modelName' => $model,
                'calledMethod' => $method,
                'methodProperties' => $params
            ];
            $response = $this->getClient()->request('POST', self::API_URI, [RequestOptions::JSON => $request]);
            if ($response->getStatusCode() !== 200) {
                $this->throwException($response->getReasonPhrase());
            }

            $body = $this->getResponseBody($response);

            if ($body['success'] === false) {
                $this->throwException(array_shift($body['errors']) ?: array_shift($body['warnings']));
            }
            return $body['data'];
        } catch (GuzzleException $e) {
            $this->throwException($e->getMessage(), $e);
        }
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client();
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws NovaPoshtaApiException
     */
    private function getResponseBody(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);
        if (empty($result)) {
            throw new NovaPoshtaApiException('Invalid response from Nova Poshta API');
        }
        return $result;
    }

    /**
     * @throws NovaPoshtaApiException
     */
    private function throwException(string $error, ?Exception $exception = null): void
    {
        $message = 'Connection to Nova Poshta API failed: %s';
        throw new NovaPoshtaApiException(sprintf($message, $error), $exception->getCode() ?? 0, $exception);
    }
}
