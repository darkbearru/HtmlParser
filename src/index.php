<?php

$loader = require __DIR__ . '/../vendor/autoload.php';


use Abramenko\HtmlParser\Parser\HtmlParser;
use Abramenko\HtmlParser\Parser\ParserFacade;
use \Abramenko\HtmlParser\Parser\Repository\UrlRepository;
use Abramenko\HtmlParser\Parser\Service\StatisticsService;
use Abramenko\HtmlParser\Parser\Service\VisualizeService;

$url = !empty($_REQUEST['url']) ?  $_REQUEST['url'] : 'https://abram-and-co.ru';

$htmlParser =
    HtmlParser::create(
        UrlRepository::create($url)->get()
    )->parse();

$parserFacade =
    new ParserFacade(
        $htmlParser,
        StatisticsService::create("Статистика",
            VisualizeService::create("Структура", null)
        )
    );

$parserFacade->run()->display();
