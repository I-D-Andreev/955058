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
        $this->pageSize = 3;
        $this->country = 'gb';

        $this->updateIntervalMinutes = 20;
    }


    public function getNews(){
        // Update per set interval as there is a maximum limit on API requests per day.
        
        $news = News::firstOrCreate(['id'=>1]);

        $current = time();
        $newsDateTime = strtotime($news->updated_at);

        $diffSeconds = $current - $newsDateTime;
        if(strlen($news->json)==0 || $diffSeconds >= ($this->updateIntervalMinutes*60)){
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

        // In case the data is the same (and updated_at has not changed), update the updated_at
        $news->touch();

        return $news;
    }
}