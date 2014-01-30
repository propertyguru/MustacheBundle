MustacheBundle
=============

Hello world! This is our implementation of Mustache for SF2.
The registration of the tempalte engine was done by checking the examples of:
[Symfony\Component\Templating\PhpEngine](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Templating/PhpEngine.php)


It requires Mustache.php
[Mustache.php](https://github.com/bobthecow/mustache.php)

- This implementation does cache the processed templates (caching handled by Mustache.php);
- This implementation ONLY allows MUSTACHE partials;

Documentation
-------------

TODO hehehe

Installation
------------
Add it to your composer.
composer update.

Register the bundle on your AppKernel.php
```php
<?php
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Propertyguru\MustacheBundle\PropertyguruMustacheBundle(),
            ...
```
