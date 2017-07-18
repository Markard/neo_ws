<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Api;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Implementation of an API client with Guzzle lib.
 */
class GuzzleBasedClient implements ClientInterface
{
    const TIMEOUT = 10.0;
    const FEED_URL = 'neo/rest/v1/feed';

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var ResponseMapper
     */
    private $responseMapper;

    /**
     * @param string $host full hostname with protocol.
     * @param string $apiKey auth token
     * @param ResponseMapper $responseMapper
     */
    public function __construct($host, $apiKey, ResponseMapper $responseMapper)
    {
        $this->httpClient = new Client([
            'base_uri' => $host,
            'timeout' => self::TIMEOUT,
            'exceptions' => false,
        ]);
        $this->apiKey = $apiKey;
        $this->responseMapper = $responseMapper;
    }

    /**
     * @inheritdoc
     */
    public function getFeed(Carbon $startDate, Carbon $endDate)
    {
        try {
            $response = $this->httpClient->request('GET', self::FEED_URL, [
                'query' => [
                    'api_key' => $this->apiKey,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $startDate->format('Y-m-d'),
                ]
            ]);
        } catch (TransferException $e) {
            throw new ConnectionException($e);
        }

        return $this->parseResponse($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return NeoResponse[]
     * @throws ResponseException
     */
    private function parseResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new ResponseException("Response status code is not 200 ({$response->getStatusCode()})");
        }
        $responseData = json_decode($response->getBody(), true);
        if ($responseData === null) {
            throw new ResponseException('Either null returned or returned json cannot be parsed');
        }
        if (!isset($responseData['near_earth_objects'])) {
            throw new ResponseException('The "near_earth_objects" property is missing in the response');
        }

        return $this->responseMapper->map($responseData['near_earth_objects']);
    }
}
