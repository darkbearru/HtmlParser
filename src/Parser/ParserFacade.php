<?php

namespace Abramenko\HtmlParser\Parser;

use Abramenko\HtmlParser\Parser\Service\InterfaceService;
use Abramenko\HtmlParser\Parser\Tags\InterfaceTag;

final class ParserFacade
{
    public function __construct(
        private readonly InterfaceParser  $interfaceParser,
        private readonly InterfaceService $interfaceService
    ) {
    }

    public function run(): self {
        $this->processData($this->interfaceParser->getData());
        return $this;
    }

    public function display() : self {
        $this->interfaceService->display();
        return $this;
    }

    public function getService() : InterfaceService {
        return  $this->interfaceService;
    }

    private function processData(array $tagsList, int $deep = 0): void {
        $count = count($tagsList);
        foreach ($tagsList as $index => $tag) {
            $this->interfaceService->action($tag, $deep, $index !== $count ? $index : -1);
            $children = $tag->getChildren();
            if (!empty($children)) {
                $this->processData($children, $deep + 1);
            }
        }
    }
}