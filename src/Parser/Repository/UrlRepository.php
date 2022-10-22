<?php

namespace Abramenko\HtmlParser\Parser\Repository;

class UrlRepository implements InterfaceRepository
{
    public function __construct(private readonly string $url) {
    }

    public function get(): ?string {
        try {
            return file_get_contents(
                $this->guardUrl($this->url)
            );
        } catch (\Exception $exception) {
            echo "Can't read url";
        }
        return null;
    }

    public static function create(string $url): self {
        return new self($url);
    }

    private function guardUrl(string $url): string {
        if (preg_match('/(.*\?)(.*)?/uim', $url, $matches)) {
            $url = $matches[1] . urlencode($matches[2]);
        }
        return $url;
    }
}