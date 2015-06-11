<?php

namespace Metaculous;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigExtension extends Twig_Extension
{
    private $parser;

    public function __construct(array $ignore = [], array $rig = [])
    {
        $this->parser = new Parser;
        $this->parser->ignore($ignore);
        $this->parser->rig($rig);
    }

    public function getName()
    {
        return 'metaculous';
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter(
                'metaculous_description',
                [$this->parser, 'description']
            ),
            new Twig_SimpleFilter(
                'metaculous_keywords',
                function ($text, $amount = 10, $ignore = []) {
                    return implode(
                        ', ',
                        $this->parser->keywords($text, $amount, $ignore)
                    );
                }
            ),
        ];
    }
}

