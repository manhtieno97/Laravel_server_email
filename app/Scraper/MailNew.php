<?php

namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Mail;
class MailNew
{

    public function scrape()
    {
    	$url = 'http://mail.todo.com/email';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $crawler->filter('td.minwidth table table table')->each(
            function (Crawler $node) {
                
				print_r($node->text());
            }
        );
        
        
    }
}