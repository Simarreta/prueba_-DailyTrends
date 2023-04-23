<?php


namespace App\Service;


use GuzzleHttp\Client;
use Symfony\Component\Dotenv\Dotenv;

class Gnews
{
    const BASE_URI = 'https://gnews.io/api/v4/';
    private $apiKey;
    private $client;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env');

        $this->apiKey = $_ENV['API_KEY'];
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }


    public function getTopNews(string $lang = 'es', int $maxResults = 10): array
    {
        $query = [
            'lang' => $lang,
            'max' => $maxResults,
            'token' => $this->apiKey,
            'q' => '"El País" AND "El Mundo"' //ESTO NO VA BIEN, revisar por qué en la API
        ];

        $response = $this->client->request('GET', 'search', ['query' => $query]);
        $data = json_decode($response->getBody(), true);

        $articles = [];
        foreach ($data['articles'] as $article) {
            $articles[] = [
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
                'url' => $article['url'],
                'image' => $article['image'],
                'publishedAt' => $article['publishedAt'],
                'source' => $article['source']['name'],
            ];
        }

        return $articles;
    }
}
