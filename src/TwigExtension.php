<?php

namespace Metaculous;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigExtension extends Twig_Extension
{
    public function getName()
    {
        return 'metaculous';
    }

    public function getFilters()
    {
        $parser = new Parser;
        return [
            new Twig_SimpleFilter(
                'metaculous_description',
                function ($text) use ($parser) {
                    return $parser->description($text);
                }
            ),
            new Twig_SimpleFilter(
                'metaculous_keywords',
                function ($text) use ($parser) {
                    return implode(', ', $parser->keywords($text));
                }
            ),
        ];
    }
}

