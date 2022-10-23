<?php

namespace Parser\Tags;

use Abramenko\HtmlParser\Parser\HtmlParser;
use Abramenko\HtmlParser\Parser\Tags\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    private Tag $tag;

    public function __construct(?string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->tag = Tag::create(
            "DIV",
            HtmlParser::parseAttributes(['class="w-50 mt-5"', 'data-id="test_id"', 'data-source="Проверка"']),
            "Обычный контент тега",
            false
        );
    }

    public function testCreate() {
        $this->assertInstanceOf(Tag::class, $this->tag);

    }

    public function testGetName() {
        $this->assertEquals('DIV', $this->tag->getName());
    }

    public function testGetAttributes() {
        $attributes = $this->tag->getAttributes();
        $this->assertCount(3, $attributes);
        $this->assertEquals("class", $attributes['class']->getName());
        $this->assertEquals("Проверка", $attributes['data-source']->getValue());
    }

    public function testGetAttribute() {
        $this->assertEquals("w-50 mt-5", $this->tag->getAttribute("class")->getValue());
    }

    public function testGetContent() {
        $this->assertEquals("Обычный контент тега", $this->tag->getContent());
    }

    public function testSetContent() {
        $this->tag->setContent("Test");
        $this->assertEquals("Test", $this->tag->getContent());
    }


    public function testSetChildren() {
        $this->tag->setChildren([1, 2, 3]);
        $this->assertCount(3, $this->tag->getChildren());
    }

    public function testGetChildren() {
        $this->tag->setChildren([1, 2, 3]);
        $this->assertEquals(2, $this->tag->getChildren()[1]);
    }

}
