MustacheBundle
=============

Hello world! This is our implementation of Mustache for SF2.
The registration of the template engine was done by checking the examples of:
[Symfony\Component\Templating\PhpEngine](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Templating/PhpEngine.php)


It requires Mustache.php
[Mustache.php](https://github.com/bobthecow/mustache.php)

- This implementation does cache the processed templates (caching handled by Mustache.php);
- This implementation ONLY allows MUSTACHE partials;

Documentation
-------------

If it is needed to have other extensions than 'mustache' to be recognized as mustache templates,
then expose the Semantic Configuration for this bundle:

```
console config:dump-reference PropertyguruMustacheBundle

# Default configuration for "PropertyguruMustacheBundle"
propertyguru_mustache:

    # Templates extensions that should be loaded
    extensions:

        # Default:
        - mustache
```

Have mustache templates with 'ms' extension instead?
just add on your app/config/config.yml

```
propertyguru_mustache:
    extensions:
        - mustache
        - ms
```

Even if the 'mustache' is removed, it will still be available by default.

Add Helper
----------

See more detail: https://github.com/bobthecow/mustache.php/wiki/FILTERS-pragma

**UnitInformationWidget.php**

```php
...
// We need to get actual template engine from DelegatingEngine object
$delegatingEngine = $this->content->get('templating')->getEngine();
$templateEngine = $delegatingEngine->getEngine('GuruMobileLiteDeveloperBundle:widgets:unit-information.html.ms')

if ($templateEngine instanceof MustacheEngine) {

    // Convert 100000 to 100,000 
    $templateEngine->addHelper('decimal', function ($value) {
        return number_format((string)$value);
    }
}
...
```

**unit-information.html.ms**
```html
...
{{%FILTERS}}        <--- Should place in the top of template
...
<div>{{ price | decimal }}</div>
...
```

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

And let Symfony's framework know that the templating service can render mustache
from:

```yaml
# app\config\config.yml
framework:
    templating:
        engines: ['twig']
```

to

```yaml
# app\config\config.yml
framework:
    templating:
        engines: ['twig', 'mustache']
```