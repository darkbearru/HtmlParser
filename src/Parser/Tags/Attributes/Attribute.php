<?php

namespace Abramenko\HtmlParser\Parser\Tags\Attributes;

final class Attribute implements InterfaceAttributes
{
    public function __construct(private readonly string $name, private readonly ?string $value) {}

    /**
     * Инициализация класса и одновременный разбор аттрибута
     * @param string $attribute
     * @return InterfaceAttributes|null
     */
    public static function get(string $attribute): ?InterfaceAttributes {
        list($name, $value) = self::parse($attribute);
        if(!empty($name)) return new self($name, $value);
        return null;
    }

    /**
     * Разбираем строку на наименование аттрибута и значение.
     * Помним что значения может и не быть
     * @param string $attribute
     * @return array
     */
    private static function parse(string $attribute): array {
        if(preg_match('/^([\w_-]*?)(=["\'](.*)["\'])?$/uim', $attribute, $matches)) {
            return [
                $matches[1],
                !empty($matches[3]) ? $matches[3] : null
            ];
        }
        return ['', null];
    }

    /**
     * Предусматриваем получение данных в виде простого объекта
     * @return object
     */
    public function getAttribute() : object {
        return (object) [
            'name' => $this->name,
            'value' => $this->value
        ];
    }

    /**
     * Получаем наименование аттрибута
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * Получаем значение
     * @return string|null
     */
    public function getValue() : ?string {
        return $this->value;
    }

    /**
     * Реализуем «магический» метод прелбразования класса в строку
     * @return string
     */
    public function __toString() : string {
        return $this->name .($this->value ? '=' . $this->value : '');
    }
}