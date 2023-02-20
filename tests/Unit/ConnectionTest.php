<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use SergeyNezbritskiy\NovaPoshta\Connection;
use SergeyNezbritskiy\NovaPoshta\NovaPoshtaApiException;

/**
 * Class ConnectionTest
 * Unit tests for class \SergeyNezbritskiy\NovaPoshta\Connection
 * @see Connection
 */
class ConnectionTest extends TestCase
{
    private Connection $object;
    private Client|MockObject $clientMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->object = new Connection('api-key', $this->clientMock);
    }

    public function testException(): void
    {
        $exceptionMock = new TransferException('Test');
        $this->clientMock->expects($this->once())->method('request')->willThrowException($exceptionMock);
        $this->expectException(NovaPoshtaApiException::class);
        $this->expectExceptionMessage('Connection to Nova Poshta API failed: Test');
        $this->object->post('model', 'method');
    }

    /**
     * @throws Exception
     */
    public function testInvalidResponseCode(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(201);
        $response->method('getReasonPhrase')->willReturn('Test');
        $this->clientMock->expects($this->once())->method('request')->willReturn($response);

        $this->expectException(NovaPoshtaApiException::class);
        $this->expectExceptionMessage('Connection to Nova Poshta API failed: Test');

        $this->object->post('model', 'method');
    }

    /**
     * @throws Exception
     */
    public function testFalsySuccessStatus(): void
    {
        $contentJson = json_encode(['success' => false, 'errors' => ['Test Error']]);
        $response = $this->createResponse($contentJson);
        $this->clientMock->method('request')->willReturn($response);

        $this->expectException(NovaPoshtaApiException::class);
        $this->expectExceptionMessage('Connection to Nova Poshta API failed: Test Error');

        $this->object->post('model', 'method');
    }

    /**
     * @throws Exception
     */
    public function testInvalidBody(): void
    {
        $response = $this->createResponse('NotAJson');
        $this->clientMock->expects($this->once())->method('request')->willReturn($response);

        $this->expectException(NovaPoshtaApiException::class);
        $this->expectExceptionMessage('Invalid response from Nova Poshta API');

        $this->object->post('model', 'method');
    }

    /**
     * @param string $content
     * @return ResponseInterface
     * @throws Exception
     */
    private function createResponse(string $content): ResponseInterface
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $bodyMock = $this->createMock(StreamInterface::class);
        $bodyMock->method('getContents')->willReturn($content);
        $response->method('getBody')->willReturn($bodyMock);
        return $response;
    }
}
