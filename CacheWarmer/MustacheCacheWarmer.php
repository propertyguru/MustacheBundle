<?php

namespace Propertyguru\MustacheBundle\CacheWarmer;

use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class MustacheCacheWarmer implements CacheWarmerInterface
{
    private $container;
    private $templateFinder;

    public function __construct(ContainerInterface $container, TemplateFinderInterface  $templateFinder)
    {
        $this->container = $container;
        $this->templateFinder = $templateFinder;
    }

    public function warmUp($cacheDir)
    {
        $mustache = $this->container->get('mustache');
        // Get all the templates
        $templates = $this->templateFinder->findAllTemplates();

        foreach ($templates as $template) {
            // We only handle the tempaltes to be used by mustache
            $engine = $template->get('engine');

            if ('mustache' !== $engine) {
                continue;
            }

            try {
                // Force the load, that activates the cache from Mustache.php
                $mustache->loadTemplate($template);
            } catch (\Exception $e) {
            }
        }
    }

    /*
     * Is it Optional to warmup our Mustache tempaltes? YES
     */
    public function isOptional()
    {
        return true;
    }
}