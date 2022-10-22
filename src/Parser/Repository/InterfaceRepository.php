<?php

namespace Abramenko\HtmlParser\Parser\Repository;

interface InterfaceRepository
{
    public function get (string $url) : ?string;
}