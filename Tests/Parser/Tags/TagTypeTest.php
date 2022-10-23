<?php

namespace Parser\Tags;

use Abramenko\HtmlParser\Parser\Tags\TagType;
use PHPUnit\Framework\TestCase;

class TagTypeTest extends TestCase
{
    public function testTagType() {
        $this->assertEquals(true, TagType::isClosingTag('TD'));
        $this->assertEquals(false, TagType::isClosingTag('IMG'));
    }
}
