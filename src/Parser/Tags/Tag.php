<?php

namespace Abramenko\HtmlParser\Parser\Tags;

use Abramenko\HtmlParser\Parser\Tags\Attributes\Attribute;

final class Tag implements InterfaceTag
{
    protected array $children = [];

    public function __construct(
        private readonly string $tagName,
        private readonly ?array $attributes,
        private ?string         $textContent,
        private readonly bool   $noneClosed = false
    ) {
    }

    /**
     * Нам дана строка, вытаскиваем из неё первый тег, и возвращаем остатки строки
     * @param string $tagName
     * @param array|null $attributes
     * @param string $textContent
     * @param bool $noneClosed
     * @return Tag
     */
    public static function create(string $tagName, ?array $attributes, string $textContent, bool $noneClosed = false): self {
        return new self($tagName, $attributes, $textContent, $noneClosed);
    }

    public function getAttribute(string $name): ?Attribute {
        if (!empty($this->attributes[$name])) return $this->attributes[$name];
        return null;
    }

    public function getAttributes(): ?array {
        return $this->attributes;
    }

    public function getChildren(): array {
        return $this->children;
    }

    public function setChildren(array $children) {
        $this->children = $children;
    }

    public function getName(): string {
        return $this->tagName;
    }

    public function setContent(string $content) {
        $this->textContent = $content;
    }

    public function getContent(): ?string {
        return $this->textContent;
    }

    public function isNoneClosed(): bool {
        return $this->noneClosed;
    }
}