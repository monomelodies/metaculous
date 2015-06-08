<?php

namespace Metaculous;

class Parser
{
    /**
     * Extract optimum meta description from $text, following best practices.
     *
     * - max $length chars (default: 155)
     * - 25-30 words
     * - max 2 sentences
     * - no HTML
     */
    public function description($text, $length = 155)
    {
        $text = strip_tags($text);
        $text = trim(preg_replace("@\s+@ms", ' ', $text));
        $sentences = preg_split(
            '@([\.!\?]+)@m',
            $text,
            3,
            PREG_SPLIT_DELIM_CAPTURE
        );
        if (count($sentences) == 5) {
            array_pop($sentences);
        }
        $text = implode('', $sentences);
        $words = explode(' ', $text);
        while (count($words) > 30 || strlen($text) > 155) {
            array_pop($words);
            $text = implode(' ', $words).'...';
        }
        return $text;
    }

    public function keywords($text, $amount = 10, $ignore = [])
    {
        $text = preg_replace("@\s+@ms", ' ', $text);
        $text = htmlentities(strip_tags($text));
        $text = preg_replace('@&([a-z])[a-z]+?;@', '$1', $text);
        $text = trim(preg_replace('@[^\w\s-]@', '', $text));
        $words = explode(' ', $text);
        $cntlc = [];
        $cnt = [];
        foreach ($words as $word) {
            $weight = log(strlen($word));
            $lcword = strtolower($word);
            if (in_array($lcword, $ignore)) {
                continue;
            }
            if (!isset($cnt[$word])) {
                $cnt[$word] = 0;
            }
            $cnt[$word] += $weight;
            if (!isset($cntlc[$lcword])) {
                $cntlc[$lcword] = 0;
            }
            $cntlc[$lcword] += $weight;
        }
        arsort($cnt);
        arsort($cntlc);
        $popular = array_shift(array_chunk(array_keys($cntlc), $amount));
        $keywords = [];
        foreach ($popular as $word) {
            foreach ($cnt as $spelling => $counted) {
                if (strtolower($spelling) == $word) {
                    $keywords[] = $spelling;
                }
            }
        }
        return $keywords;
    }
}

