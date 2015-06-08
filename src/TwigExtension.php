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
                [$parser, 'description']
            ),
            new Twig_SimpleFilter(
                'metaculous_keywords',
                function ($text, $amount = 10, $ignore = []) use ($parser) {
                    return implode(
                        ', ',
                        $parser->keywords($text, $amount, $ignore)
                    );
                }
            ),
        ];
    }
}

