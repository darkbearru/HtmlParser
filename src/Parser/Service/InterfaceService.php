<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\InterfaceParser;

interface InterfaceService
{
    public static function create (string $nameService, ?InterfaceService $handler) : self;
    public function actionByItem(mixed $dataItem) : self;
    public function actionByAll(array $dataItems) : self;
    public function display() : self;
}