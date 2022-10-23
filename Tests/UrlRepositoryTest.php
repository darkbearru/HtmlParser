<?php

namespace Abramenko\HtmlParser\Parser\Repository;

use PHPUnit\Framework\TestCase;

class UrlRepositoryTest extends TestCase
{
    public function testUrlData () {
        $data = UrlRepository::create('https://abram-and-co.ru')->get();
        $expected =
"<!DOCTYPE html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <title>Abram&Co</title>
</head>
<body>
<h1>It's worked</h1>
</body>
</html>";
        $this->assertEquals($expected, $data);
    }
}
