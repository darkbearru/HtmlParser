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
        $data = $this->interfaceParser->getData();
        $this->processData($data);
        $this->interfaceService->actionByAll($data);
        return $this;
    }

    public function display(): self {
        $this->interfaceService->display();
        return $this;
    }

    public function getService(): InterfaceService {
        return $this->interfaceService;
    }

    private function processData(array $tagsList): void {
        foreach ($tagsList as $index => $tag) {
            $children = $tag->getChildren();
            if (!empty($children)) {
                $this->processData($children);
            }
            $this->interfaceService->actionByItem($tag);
        }
    }
}