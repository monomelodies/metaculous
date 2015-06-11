# Twig extension

Metaculous comes bundled with a Twig extension for convenience. Other
templating engines will have their own mechanism, but using the Twig extension
as an example should be trivial to implement.

## Usage
Assuming a `Twig_Enivronment` object stored in `$twig`, it's really simple:

```php
<?php

$twig->addExtension(new Metaculous\TwigExtension);

```

The extension constructor takes two optional arguments: `$ignore` and `$rig`
(see [the section on the `Parser` for details](parser.md)).

In your template, use one of the two filters the extension defines:

```twig
<meta name="keywords" content="{{ text|metaculous_keywords(amount, ignore) }}">
<meta name="description" content="{{ text|metaculous_description(length) }}">
```

The optional parameters work the same as the corresponding parameters in the
`Parser`.

