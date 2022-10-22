<?php

namespace Abramenko\HtmlParser\Parser\Repository;

class UrlRepository implements InterfaceRepository
{
    private static UrlRepository $instance;

    public function get(string $url): ?string {
        try {
            return file_get_contents(
                $this->guardUrl($url)
            );
        } catch (\Exception $exception) {
            echo "Can't read url";
        }
        return null;
    }

    public static function getContent(string $url): ?string {
        self::$instance = new UrlRepository();
        return self::$instance->get($url);
    }

    private function guardUrl(string $url): string {
        if (preg_match('/(.*\?)(.*)?/uim', $url, $matches)) {
            $url = $matches[1] . urlencode($matches[2]);
        }
        return $url;
    }
}