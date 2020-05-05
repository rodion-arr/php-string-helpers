# PHP String helpers

![PHP Composer](https://github.com/rodion-arr/php-string-helpers/workflows/PHP%20Composer/badge.svg) [![codecov](https://codecov.io/gh/rodion-arr/php-string-helpers/branch/master/graph/badge.svg)](https://codecov.io/gh/rodion-arr/php-string-helpers) [![Latest Stable Version](https://poser.pugx.org/rodion-arr/php-string-helpers/v/stable)](https://packagist.org/packages/rodion-arr/php-string-helpers) [![License](https://poser.pugx.org/rodion-arr/php-string-helpers/license)](https://packagist.org/packages/rodion-arr/php-string-helpers)

A trait for mixing-in some useful string helpers

# Installation
`composer require rodion-arr/php-string-helpers`

# Usage
```php
namespace Doorway;

require_once __DIR__.'/vendor/autoload.php'; // Autoload files using Composer

use RodionARR\StringHelpers\StringHelper;

class MyClass
{
    use StringHelper;

    public function __construct(array $keywords)
    {
        $this->toUpperCase('some string');
        $this->cleanUpString('some string');
        $this->addTrailingDot('some string');
        $this->sanitizeBladeString('some string');
        
        // more examples in unit test file
    }
}
```
