<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\InterfaceParser;

interface InterfaceService
{
    public static function create (?InterfaceService $handler) : self;
    public function action(mixed $dataItem, int $deep = 0, int $itemIndex = 0) : self;
    public function display() : self;
}