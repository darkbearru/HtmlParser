<?php

namespace Abramenko\HtmlParser\Parser\Display;

class Display implements InterfaceDisplay
{
    public function __construct(private readonly string $caption, private readonly mixed $data) {
    }

    public static function create(string $caption, mixed $data) : InterfaceDisplay {
        if (is_array($data)) return DisplayArray::create($caption, $data);
        if (is_string($data)) return DisplayString::create($caption, $data);
        return new self($caption, $data);
    }

    public function show() {
        echo "<h3>$this->caption</h3>\r\n";
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
    }
}