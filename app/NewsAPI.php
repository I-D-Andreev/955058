<?php

use App\News;
namespace App;

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

        $this->updateIntervalMinutes = 15;
    }


    public function getNews(){
        return $this->buildAPICall();

        // $news = News::findOrFail(1);

        // $current = new \DateTime();
        // $newsDateTime = new \DateTime($news->updated_at);

        // $diff = $newsDateTime->diff($current);
        // if(strlen($news->json)==0 || $diff->i >= $updateIntervalMinutes){
        //     // return $this->updateNews($news)->json;
        //     return "need update";
        // } else {
        //     // return $news->json;
        //     return "all good";
        // }
    }

    private function buildAPICall(){
        return $this->newsSite.'country='.$this->country."&pageSize=".$this->pageSize."&apiKey=".$this->apiKey;
    }

    private function updateNews($news) {
        return $news;
    }
}