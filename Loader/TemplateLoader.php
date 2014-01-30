<?php

namespace Propertyguru\MustacheBundle\Loader;

use \Mustache_Template as MustacheTemplate;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

/**
 * Mustache Loader using Symfony\Component\Templating\Loader\LoaderInterface
 */
class TemplateLoader implements \Mustache_Loader
{
    protected $templates;
    protected $fileLoader;
    protected $parser;

    public function __construct(TemplateNameParserInterface $parser, LoaderInterface $fileLoader)
    {
        $this->parser = $parser;
        $this->fileLoader = $fileLoader;
        $this->templates = array();
    }

    public function load($name)
    {
        if ($name instanceof TemplateReference) {
            $name = $name->getLogicalName();
        }

        if (!isset($this->templates[$name])) {
            $this->templates[$name] = $this->loadFile($name);
        }

        return $this->templates[$name];
    }

    private function supports($name)
    {
        if ($name instanceof MustacheTemplate) {
            return true;
        }

        $template = $this->tempalteNameParser->parse($name);
        return 'mustache' === $template->get('engine');
    }


    private function loadFile($name)
    {
        // Try to find the file with Symfony Locator
        $fileReference = $this->parser->parse($name);
        $file = $this->fileLoader->load($fileReference);

        if (false === $file) {
            throw new \InvalidArgumentException(sprintf('Mustache: Unable to find template "%s"', (string) $fileReference));
        }

        return $file->getContent();
    }
}
