<?php

namespace Abramenko\HtmlParser\Parser\Tags\Attributes;

use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testCreateAttribute() {
        $class = Attribute::get('test="2333"');
        $this->assertEquals("test", $class->getName());
        $this->assertEquals("2333", $class->getValue());
        $class = Attribute::get("test");
        $this->assertEquals(null, $class->getValue());
        $class = Attribute::get("test=23233");
        $this->assertEquals(null, $class);
    }
}
