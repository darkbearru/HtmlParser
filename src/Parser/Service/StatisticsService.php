<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\InterfaceParser;
use Abramenko\HtmlParser\Parser\Tags\InterfaceTag;

class StatisticsService implements InterfaceService
{
    private array $statistics = [];

    private function __construct(private readonly ?InterfaceService $handler) {

    }

    public static function create(?InterfaceService $handler): InterfaceService {
        return new self($handler);
    }

    public function display(): InterfaceService {
        echo '<h3>Кол-во тегов:</h3>';
        echo '<pre>';
        print_r ($this->statistics);
        echo '</pre>';
        if(!empty($this->handler)) return $this->handler->display();
        return $this;
    }

    public function action(mixed $dataItem, int $deep = 0, int $itemIndex = 0): InterfaceService {
        if ($dataItem instanceof InterfaceTag) {
            $this->tagStatistics($dataItem);
        }
        // Если имеется указатель на следующий сервис, вызываем его
        if(!empty($this->handler)) {
            return $this->handler->action($dataItem, $deep, $itemIndex);
        }
        return $this;
    }

    private function tagStatistics(InterfaceTag $tagInfo): void {
        if ($tagInfo->getName() === '!DOCTYPE') return;
        $this
            ->incrementCounter('all')
            ->incrementCounter($tagInfo->getName());
    }

    private function incrementCounter(string $key, int $value = 1): self {
        if (empty($this->statistics[$key])) $this->statistics[$key] = 0;
        $this->statistics[$key] += $value;
        return $this;
    }
}