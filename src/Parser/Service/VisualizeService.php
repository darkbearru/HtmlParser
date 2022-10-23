<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\Display\Display;
use Abramenko\HtmlParser\Parser\Tags\InterfaceTag;

class VisualizeService implements InterfaceService
{
    private string $output = '';

    private function __construct(private readonly string $nameService, private readonly ?InterfaceService $handler) {
    }

    public static function create(string $nameService, ?InterfaceService $handler): InterfaceService {
        return new self($nameService, $handler);
    }

    public function display(): InterfaceService {
        Display::create($this->nameService, $this->output)->show();
        if(!empty($this->handler)) return $this->handler->display();
        return $this;
    }


    public function actionByItem(mixed $dataItem): InterfaceService {
        if(!empty($this->handler)) return $this->handler->actionByItem($dataItem);
        return $this;
    }

    public function actionByAll(array $dataItems): InterfaceService {
        $this->output = $this->showTree($dataItems);
        if(!empty($this->handler)) return $this->handler->actionByAll($dataItems);
        return $this;
    }

    private function showTree(array $data) : string {
        $result = '';
        foreach ($data as $tag) {
            $children = $tag->getChildren();
            $childrenString = '';
            if (!empty($children)) {
                $childrenString = $this->showTree($children);
            }
            $result .= "<li>{$tag->getName()}$childrenString</li>";
        }
        return "<ul>$result</ul>";
    }
}