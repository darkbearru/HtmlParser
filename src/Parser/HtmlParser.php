<?php

namespace Abramenko\HtmlParser\Parser;

class HtmlParser extends AbstractParser
{
    /**
     * Инициализация класса, передача сущностей для чтения данных
     * А также запуск обработки
     * @param string $htmlData
     * @return AbstractParser
     */
    public static function create(string $htmlData): AbstractParser {
        return new self($htmlData);
    }

    /**
     * Добавление сервиса по обработке данных
     * @return $this
     */
    public function addService() : self {
        // TODO: Implement addService() method.
        return $this;
    }

    /**
     * Начало обработки
     * @return $this
     */
    public function parse() : self {
        return $this;
    }

    /**
     * Получение тега из данных
     * @return void
     */
    protected function getTag() : void {
        // TODO: Implement getTag() method.
    }
}