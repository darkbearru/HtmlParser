<?php

namespace Abramenko\HtmlParser\Parser\Display;

class DisplayArray implements InterfaceDisplay
{

    public function __construct(private readonly string $caption, private readonly mixed $data) {
    }

    public static function create(string $caption, mixed $data): InterfaceDisplay {
        return new self($caption, $data);
    }

    public function show() {
        echo "<h3>$this->caption</h3>";
        foreach ($this->data as $key => $value) {
            echo sprintf("%s — %s<br />\r\n", $key, $value);
        }
    }

}