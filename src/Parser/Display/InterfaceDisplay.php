<?php

namespace Abramenko\HtmlParser\Parser\Display;

interface InterfaceDisplay
{
    function __construct (string $caption, mixed $data);
    public function show();
    public static function create(string $caption, mixed $data) : self;
}