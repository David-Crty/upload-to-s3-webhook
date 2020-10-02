<?php


namespace App;


use App\Helper\Env;
use App\Model\ResourceInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WebHook
{
    private HttpClientInterface $client;
    
    public function __construct()
    {
        $this->client = HttpClient::create();
    }
    
    public function call(ResourceInterface $resource): int
    {
        $serializer = new Serializer();
    
        $response = $this->client->request(
            'POST',
            Env::get('WEBHOOK_ENDPOINT'),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $serializer->serialize($resource, 'json', ['groups' => ['main_webhook']])
            ]
        );
    
        return $response->getStatusCode();
    }
}