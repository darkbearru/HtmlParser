<?php

namespace Abramenko\HtmlParser\Parser;

use Abramenko\HtmlParser\Parser\Tags\Tag;
use Abramenko\HtmlParser\Parser\Tags\TagType;

final class HtmlParser implements InterfaceParser
{
    private array $htmlTree = [];

    public function __construct(private string $htmlData) {
    }

    public function getData(): array {
        return $this->htmlTree;
    }

    /**
     * Инициализация класса, передача сущностей для чтения данных
     * А также запуск обработки
     * @param string $htmlData
     * @return self
     */
    public static function create(string $htmlData): self {
        return new self($htmlData);
    }

    /**
     * Начало обработки
     * @return $this
     */
    public function parse(): self {
        $this->htmlData = $this->cleanUpHtml($this->htmlData);
        $this->htmlTree = $this->parseHtml($this->htmlData, null);
        return $this;
    }

    /**
     * Рекурсивная функция парсинга html
     * @param string $html
     * @param Tag|null $parent
     * @return array
     */
    protected function parseHtml(string &$html, Tag|null $parent): array {
        $result = [];
        $firstTag = $this->getTag($html, 0);
        if (!$firstTag) return $result;
        while ($nextTag = $this->getTag($html, $firstTag?->offset ?: 0)) {
            $html = mb_substr($html, $firstTag->offset, null, 'utf-8');

            if ($parent && ($parent->getName() === $firstTag->tagName) && $firstTag->isClosingTag) {
                return $result;
            }

            $tag = Tag::create($firstTag->tagName, $firstTag->attributes, '');

            if (!$firstTag->isSelfClosedTag) {
                if ($firstTag->tagName === $nextTag->tagName && $firstTag->needToClose && !$firstTag->isClosingTag) {
                    // Вариант когда следующий тег сразу же является закрывающимся
                    $tag->setContent($nextTag->content);
                    $html = mb_substr($html, $nextTag->offset - $firstTag->offset, null, 'utf-8');
                }else if ($firstTag->needToClose) {
                    $ret = $this->parseHtml($html, $tag);
                    $tag->setChildren($ret);
                }
            }

            $result[] = $tag;
            $firstTag = $this->getTag($html, 0);
        }
        return $result;
    }

    /**
     * Получение тега из данных
     * @param string $html
     * @param int $offset
     * @return object|null
     */
    protected function getTag(string $html, int $offset = 0): ?object {
        if (!empty($offset)) $html = mb_substr($html, $offset, null, 'utf-8');

        if (preg_match('~^(.*?)<(/)?([\w!_-]*)\s?([^>]*?)?(/)?>~ui', $html, $matches)) {
            $isClosingTag = !empty($matches[2]);
            $tagName = mb_strtoupper($matches[3], 'utf-8');
            $isSelfClosedTag = !empty($matches[5]);
            $attributes = !empty($matches[4]) ? $this->getAttributes($matches[4]) : null;
            $offset += mb_strlen($matches[0], 'utf-8');
            return (object)[
                'tagName' => $tagName,
                'needToClose' => TagType::isClosingTag($tagName),
                'isClosingTag' => $isClosingTag,
                'isSelfClosedTag' => $isSelfClosedTag,
                'attributes' => $attributes,
                'content' => $matches[1],
                'offset' => $offset
            ];
        }
        return null;
    }

    /**
     * Получаем из строки аттрибуты и разбиваем их на имя, значение
     * @param string $attributes
     * @return array
     */
    protected function getAttributes(string $attributes): array {
        $result = [];
        $list = preg_split('~\s+\b~ui', $attributes);
        foreach ($list as $attribute) {
            if (preg_match('/^([\w_-]*?)(=["\'](.*)["\'])?$/uim', $attribute, $matches)) {
                $result[] = [
                    'name' => $matches[1],
                    'value' => !empty($matches[3]) ? $matches[3] : null
                ];
            }
        }
        return $result;
    }

    /**
     * Чистим html, поскольку всё-таки цели не было сделать тру-парсер,
     * позволяем себе некие вольности, в виде убирания лишних пробелов,
     * комментариев и избавляемся от тела js
     * @param string $htmlData
     * @return string
     */
    private function cleanUpHtml(string $htmlData) : string {
        $htmlData = preg_replace('/(^\s+|\r|\n|\s+$)/uim', '', $htmlData);
        $htmlData = preg_replace('/<!--.*?-->/uism', '', $htmlData);
        return preg_replace('~(<script.*?</script>)~uism', '<script></script>', $htmlData);
    }

}