<?php

namespace Abramenko\HtmlParser\Parser;

use Abramenko\HtmlParser\Parser\Tags\Tag;
use Abramenko\HtmlParser\Parser\Tags\TagType;

final class HtmlParser extends AbstractParser
{
    private array $noneClosedTags = [];

    /**
     * Инициализация класса, передача сущностей для чтения данных
     * А также запуск обработки
     * @param string $htmlData
     * @return AbstractParser
     */
    public static function create(string $htmlData): AbstractParser {
        $htmlData = preg_replace('/(^\s+|\r|\n|\s+$)/uim', '', $htmlData);
        $htmlData = preg_replace('/<!--.*?-->/uism', '', $htmlData);
        $htmlData = preg_replace('~(<script.*?>).*?(</script>)~uism', '', $htmlData);
        return new self($htmlData);
    }

    /**
     * Добавление сервиса по обработке данных
     * @return $this
     */
    public function addService(): self {
        // TODO: Implement addService() method.
        return $this;
    }

    /**
     * Начало обработки
     * @return $this
     */
    public function parse(): self {
        // Логика следующая, ищем тэг, а также ищем следующий тэг
        // ЕСли первый тег закрывающийся, тогда смотрим не закрывает ли его следующий тэг
        // 1. Закрывает, то создаём тег с текстовым контентом, и переходим далее
        // 2. Если следующий другой тег, проверяем не является ли текущий тег само закрывающимся
        // Если является, то создаем тег и переходим далее
        // Если нет, то все следующие теги считаем вложением
        $this->htmlTree = $this->parseHtml($this->htmlData, null);

        $this->visualise ($this->htmlTree);

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

            if ($firstTag->tagName === $nextTag->tagName) {
                // Вариант когда следующий тег сразу же является закрывающимся
                $tag->setContent($nextTag->content);
                $html = mb_substr($html, $nextTag->offset - $firstTag->offset, null, 'utf-8');

            }else if ($firstTag->needToClose && !$firstTag->isSelfClosedTag && !$firstTag->isClosingTag) {
                $ret = $this->parseHtml($html, $tag);
                $tag->setChildren($ret);
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

    protected function visualise(array $array) {
        echo '<ul>';
        foreach ($array as $item) {
            echo '<li>';
            echo '<b>'.$item->getName().'</b>';
            if(!empty($item->getChildren())) {
                $this->visualise($item->getChildren());
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}