<?php

namespace Abramenko\HtmlParser\Parser\Tags;

use Abramenko\HtmlParser\Parser\Tags\Attributes\Attribute;

interface InterfaceTag
{
    function __construct(string $tagName, ?array $attributes, ?string $textContent, bool $noneClosed = false);

    public function getAttribute(string $name) : ?Attribute;
    public function getAttributes() : ?array;
    public function getChildren() : array;
    public function setChildren(array $children);
    public function getName() : string;
    public function getContent() : ?string;
    public function setContent(string $content);
    public function isNoneClosed() : bool;

    public static function create(string $tagName, ?array $attributes, string $textContent, bool $noneClosed = false) : self;
}