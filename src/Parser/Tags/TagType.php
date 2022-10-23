<?php

namespace Abramenko\HtmlParser\Parser\Tags;

final class TagType
{
    private static array $noneClosingTags = [
        '!DOCTYPE' => 1,
        'META' => 1,
        'LINK' => 1,
        'IMG' => 1,
        'BR' => 1

    ];
    public static function isClosingTag($name) : bool {
        return empty(self::$noneClosingTags[$name]);
    }
}