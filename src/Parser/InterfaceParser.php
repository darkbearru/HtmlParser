<?php

namespace Abramenko\HtmlParser\Parser;

use Abramenko\HtmlParser\Parser\Repository\UrlRepository;

interface InterfaceParser
{

    function __construct (string $htmlData);

    /**
     * Инициализация класса через статический метод
     * Сразу передаём в парсер текст для обработки
     * @param string $htmlData
     * @return self
     */
    public static function create (
        string $htmlData,
    ) : self;


    /**
     * Инициализация обработки
     * @return self
     */
    public function parse(): self;

    public function getData() : mixed;

}