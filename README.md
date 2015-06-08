# Metaculous
Metadata helpers

A few simple helpers to generically add metadata tag (description, keywords) to
your HTML pages, based on page content.

[Full documentation](http://metaculous.readthedocs.org)

## Installation

### Composer (recommended)
```bash
$ composer install --save monomelodies/metaculous
```

### Manual
Download or clone the files, and add `/path/to/metaculous/src` to your
autoloader for classes in the `Metaculous` namespace.

## Usage
Instantiate the Parser:

```php
<?php

use Metaculous\Parser;

$parser = new Parser;

```

Generate a short description based on random text (e.g. page content from a
database):

```php
<?php

echo '<meta name="description" content="'.$parser->description($bodyText).'">';

```

Generate top 10 keywords based on the same text:

```php
<?php

echo '<meta name="keywords" content="'.implode(', ', $parser->keywords($bodyText)).'">';

```

Of course, you could also use the keywords to e.g. display a tag cloud.

