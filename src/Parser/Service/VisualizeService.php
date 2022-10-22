<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\Tags\InterfaceTag;

class VisualizeService implements InterfaceService
{
    private string $output = '';

    private function __construct(private readonly ?InterfaceService $handler) {
    }

    public static function create(?InterfaceService $handler): InterfaceService {
        return new self($handler);
    }

    public function display(): InterfaceService {
        echo '<h3>Структура:</h3>';
        echo $this->output;
        if(!empty($this->handler)) return $this->handler->display();
        return $this;
    }


    public function action(mixed $dataItem, int $deep = 0, int $itemIndex = 0): InterfaceService {
        if ($dataItem instanceof InterfaceTag) {
            $this->tagShow($dataItem, $deep, $itemIndex);
        }
        // Если имеется указатель на следующий сервис, вызываем его
        if(!empty($this->handler)) return $this->handler->action($dataItem, $deep, $itemIndex);
        return $this;
    }

    private function tagShow (InterfaceTag $dataItem, int $deep, int $itemIndex) {
        if ($itemIndex === 0) $this->output .= '<ul>';
        $this->output .= '<li>';
        $this->output .= $dataItem->getName();
        if (count($dataItem->getChildren()) === 0) $this->output .= '</li>';
        if ($itemIndex === -1) $this->output .= '</ul>';
        if ($deep > 0) $this->output .= '</li>';
    }
}