<?php

namespace Abramenko\HtmlParser\Parser\Repository;

interface InterfaceRepository
{
    function __construct(string $url);
    public function get () : ?string;
}