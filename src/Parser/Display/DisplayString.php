<?php

namespace Abramenko\HtmlParser\Parser\Display;

class DisplayString implements InterfaceDisplay
{

    public function __construct(private readonly string $caption, private readonly mixed $data) {
    }

    public function show() {
        echo "<h3>$this->caption</h3>";
        echo $this->data."<br>\r\n";
    }

    public static function create(string $caption, mixed $data): InterfaceDisplay {
        return new self($caption, $data);
    }
}