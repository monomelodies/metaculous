<?php

namespace Metaculous;

class Parser
{
    private $ignore = [];
    private $rig = [];

    /**
     * Pass an array of words to ignore. The words are normalized automatically.
     *
     * @param array $words Array of words to ignore.
     * @return void
     */
    public function ignore(array $words)
    {
        $this->ignore = array_map([$this, 'normalize'], $words);
    }

    /**
     * Pass a hash of word/weight pairs to rig during keyword extraction. This
     * is useful to automatically prefer certain words that may not easily show
     * up otherwise, e.g. short words like "PHP".
     *
     * Note that rigged words do not necessarily appear in the keywords; if a
     * rigged word isn't used at all, or its weight is still too low, it will
     * simply be ignored.
     *
     * @param array $words Hash of words/weights to rig.
     * @return void
     */
    public function rig(array $words)
    {
        $this->rig = [];
        foreach ($words as $word => $weight) {
            $this->rig[$this->normalize($word)] = $weight;
        }
    }

    /**
     * Extract optimum meta description from $text, following best practices.
     *
     * - max $length chars (default: 155)
     * - 25-30 words
     * - max 2 sentences
     * - no HTML
     *
     * @param string $text The source text to work on.
     * @param integer $length Maximum length to extract.
     * @param integer $nrwords Maximum number of words to extract.
     * @param integer $lines Maximum number of sentences to use.
     */
    public function description($text, $length = 155, $nrwords = 30, $lines = 2)
    {
        $text = strip_tags($text);
        $text = trim(preg_replace("@\s+@ms", ' ', $text));
        $sentences = preg_split(
            '@([\.!\?]+)@m',
            $text,
            $lines + 1,
            PREG_SPLIT_DELIM_CAPTURE
        );
        if (count($sentences) == $lines + 3) {
            array_pop($sentences);
        }
        $text = implode('', $sentences);
        $words = explode(' ', $text);
        while (count($words) > $nrwords || strlen($text) > $length) {
            array_pop($words);
            $text = implode(' ', $words).'...';
        }
        return trim($text);
    }

    public function keywords($text, $amount = 10, $ignore = [])
    {
        $text = strip_tags($text);
        $words = preg_split(
            "@[^\w-]+@",
            preg_replace('@(\s-|-\s)@ms', ' ', $text)
        );
        $cntlc = [];
        $cnt = [];
        $ignore = array_map([$this, 'normalize'], $ignore);
        $ignore = array_merge($ignore, $this->ignore);
        foreach ($words as $word) {
            $lcword = $this->normalize($word);
            if (in_array($lcword, $ignore)) {
                continue;
            }
            $weight = log(strlen($lcword));
            if (!isset($cnt[$word])) {
                $cnt[$word] = isset($this->rig[$lcword]) ?
                    $this->rig[$lcword] :
                    0;
            }
            $cnt[$word] += $weight + ($lcword == $word ? 0 : 1);
            if (!isset($cntlc[$lcword])) {
                $cntlc[$lcword] = isset($this->rig[$lcword]) ?
                    $this->rig[$lcword] :
                    0;
            }
            $cntlc[$lcword] += $weight;
        }
        arsort($cnt);
        arsort($cntlc);
        $popular = array_shift(array_chunk(array_keys($cntlc), $amount));
        $keywords = [];
        foreach ($popular as $word) {
            foreach ($cnt as $spelling => $counted) {
                if ($this->normalize($spelling) == $word) {
                    $keywords[] = $spelling;
                    continue 2;
                }
            }
        }
        return trim($keywords);
    }

    private function normalize($str)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    }
}

