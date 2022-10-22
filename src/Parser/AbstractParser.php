<?php

namespace Abramenko\HtmlParser\Parser;

use Abramenko\HtmlParser\Parser\Repository\UrlRepository;

abstract class AbstractParser
{
    protected array $htmlTree = [];

    protected function __construct (
        protected string $htmlData,
    ){}

    /**
     * Инициализация класса через статический метод
     * Сразу передаём в парсер текст для обработки
     * @param string $htmlData
     * @return AbstractParser
     */
    abstract public static function create (
        string $htmlData,
    ) : AbstractParser;

    /**
     * Заглушка для функционала добавления сервисов по обработке данных
     * @return AbstractParser
     */
    abstract public function addService(): self;

    /**
     * Инициализация обработки
     * @return AbstractParser
     */
    abstract public function parse(): self;

}