<?php

namespace Nfaiz\SqlHighlighter\Config;

Use Nfaiz\SqlHighlighter\Collectors\SqlHighlighter;
use Config\Toolbar;

class Registrar
{
    public static function Toolbar(): array
    {
        return [
            'collectors' => [
                SqlHighlighter::class,
            ],
        ];
    }
}