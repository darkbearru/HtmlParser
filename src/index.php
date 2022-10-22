<?php

$loader = require __DIR__ . '/../vendor/autoload.php';


use Abramenko\HtmlParser\Parser\HtmlParser;
use Abramenko\HtmlParser\Parser\ParserFacade;
use \Abramenko\HtmlParser\Parser\Repository\UrlRepository;
use Abramenko\HtmlParser\Parser\Service\StatisticsService;
use Abramenko\HtmlParser\Parser\Service\VisualizeService;


$htmlParser =
    HtmlParser::create(
        UrlRepository::create('https://abram-and-co.ru')->get()
    )->parse();

$parserFacade =
    new ParserFacade(
        $htmlParser,
        StatisticsService::create(
            VisualizeService::create(null)
        )
    );

$parserFacade->run()->display();
