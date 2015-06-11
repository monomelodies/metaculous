# Parser
The central class handling text analysis.

Given a string of text, the parser attempts to generate an optimal array of
keywords or an optimal description.

Each word in the text is weighted, meaning longer words are preferred (since
they are generally more important).

## API

- #### ignore(array $words) ####

    Set a "global" array of words to always ignore (e.g. "the", "an" etc.). The
    words are "normalized" first, meaning they are converted to a standard form
    using `iconv`.

- #### rig(array $words) ####

    Set a "global" hash of word/weight pairs to rig during keyword extraction.
    This is useful to automatically prefer certain words that may not easily
    show up otherwise, e.g. short words like "PHP".
    
    Note that rigged words do not necessarily appear in the keywords; if a
    rigged word isn't used at all, or its weight is still too low, it will
    simply be ignored.

- #### description($text, $length = 155) ####

    For the given `$text`, return a description with maximum `$length` chars.

- #### keywords($text, $amount = 10, $ignore = []) ####

    For the given `$text`, return the top `$amount` keywords, optionally
    ignoring words in `$ignore`. Note that the `$ignore` parameter is
    complementary to the "global" ignore, meaning you can specifically
    ignore certain words for specific texts only.

