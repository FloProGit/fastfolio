<?php

namespace App\Domain\Shared\Helpers;

class QuillSanitizer
{
    public static function clean(string $html): string
    {
        // Supprimer les <span class="ql-ui" ...>...</span>
        $html = preg_replace('/<span class="ql-ui"[^>]*>.*?<\/span>/s', '', $html);

        // Transformer <li data-list="ordered"> en simple <li>
        $html = preg_replace('/(<li)\s+data-list="[^"]*"/', '$1', $html);

        return trim($html);
    }
}
