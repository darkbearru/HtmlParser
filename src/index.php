<?php

$loader = require __DIR__ . '/../vendor/autoload.php';


use Abramenko\HtmlParser\Parser\Repository\UrlRepository;


echo '<pre>';
print_r(UrlRepository::getContent('https://abram-and-co.ru?here=херня'));
echo '</pre>';