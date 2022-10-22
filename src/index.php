<?php

$loader = require __DIR__ . '/../vendor/autoload.php';


use Abramenko\HtmlParser\Parser\HtmlParser;
use \Abramenko\HtmlParser\Parser\Repository\UrlRepository;


$htmlParser =
    HtmlParser::create(
        UrlRepository::create('https://blackfire.io/login')->get()
)->parse();

