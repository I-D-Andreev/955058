<?php

namespace App;

use App\News;
use Illuminate\Support\Facades\Http;


class NewsAPI {
    private $newsSite;
    private $apiKey;
    private $pageSize;
    private $country;
    private $updateIntervalMinutes;

    public function __construct(){
        $this->newsSite = 'http://newsapi.org/v2/top-headlines?';
        $this->apiKey = env('NEWS_API_KEY');
        $this->pageSize = 5;
        $this->country = 'gb';

        $this->updateIntervalMinutes = 20;
    }


    public function getNews(){
        $news = News::firstOrCreate(['id'=>1]);

        $current = new \DateTime();
        $newsDateTime = new \DateTime($news->updated_at);

        $diff = $newsDateTime->diff($current);
        if(strlen($news->json)==0 || $diff->i >= $this->updateIntervalMinutes){
            return json_decode($this->updateNews($news)->json);
        } else {
            return json_decode($news->json);
        }
    }

    private function buildAPICall(){
        return $this->newsSite.'country='.$this->country."&pageSize=".$this->pageSize."&apiKey=".$this->apiKey;
    }

    private function updateNews($news) {
        $response = Http::get($this->buildAPICall());
        $news->json = $response->body();
        $news->save();

        return $news;
    }
}