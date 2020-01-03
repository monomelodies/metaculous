<?php

namespace Monomelodies\Metaculous;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
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
            new TwigFilter(
                'metaculous_description',
                [$this->parser, 'description']
            ),
            new TwigFilter(
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

