<?php

namespace Abramenko\HtmlParser\Parser\Tags\Attributes;

interface InterfaceAttributes
{
    function __construct(string $name, ?string $value);
    public static function get (string $attribute) : ?self;
}