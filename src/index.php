<?php

$loader = require __DIR__ . '/../vendor/autoload.php';


use Abramenko\HtmlParser\Parser\HtmlParser;
use \Abramenko\HtmlParser\Parser\Repository\UrlRepository;


$htmlParser =
    HtmlParser::create(
        UrlRepository::create('https://abram-and-co.ru?here=херня')->get()
    )->parse();

