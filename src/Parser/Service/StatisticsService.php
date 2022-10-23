<?php

namespace Abramenko\HtmlParser\Parser\Service;

use Abramenko\HtmlParser\Parser\Display\Display;
use Abramenko\HtmlParser\Parser\InterfaceParser;
use Abramenko\HtmlParser\Parser\Tags\InterfaceTag;

class StatisticsService implements InterfaceService
{
    private array $statistics = [];

    private function __construct(private readonly string $nameService, private readonly ?InterfaceService $handler) {

    }

    public static function create(string $nameService, ?InterfaceService $handler): InterfaceService {
        return new self($nameService, $handler);
    }

    public function display(): InterfaceService {
        Display::create($this->nameService, $this->statistics)->show();
        if(!empty($this->handler)) return $this->handler->display();
        return $this;
    }

    public function actionByItem(mixed $dataItem): InterfaceService {
        if ($dataItem instanceof InterfaceTag) {
            $this->tagStatistics($dataItem);
        }
        // Если имеется указатель на следующий сервис, вызываем его
        if(!empty($this->handler)) {
            return $this->handler->actionByItem($dataItem);
        }
        return $this;
    }

    public function actionByAll(array $dataItems): InterfaceService {
        if(!empty($this->handler)) {
            return $this->handler->actionByAll($dataItems);
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