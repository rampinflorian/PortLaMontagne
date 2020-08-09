<?php


namespace App\Service;


use mysql_xdevapi\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallWeatherAPIService
{
    private HttpClientInterface $client;
    protected SerializerInterface $serializer;
    private string $hostUrlAPI = "https://api.openweathermap.org/data/2.5/weather/";
    private string $apiKey = "323462b97bb0ac337f334e86128cfe01";


    /**
     * API constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->client = HttpClient::create([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        $this->serializer = $serializer;
    }

    /**
     * @param string $city
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function findByCity(string $city): array
    {
        $response = $this->client->request('GET', $this->hostUrlAPI, [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey
            ]
        ]);

        $data = [];

        if ($response->getStatusCode() == 200) {
            $weather = $response->toArray();
            $temp = $weather['main']['temp'] - 273.15;
            $temp = intval(round($temp));
            $data['temp'] = $temp;
            $data['icon'] = $weather['weather'][0]['icon'];
        } else {
            throw new Exception('Error WeatherAPI');
        }

        return [$data];
    }
}