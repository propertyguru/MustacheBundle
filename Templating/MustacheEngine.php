<?php

namespace Propertyguru\MustacheBundle\Templating;

use \Mustache_Engine as Mustache;
use \Mustache_Template as MustacheTemplate;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Propertyguru\MustacheBundle\Helper\MustacheHelperInterface;

/**
 * MustacheEngine is an engine able to render Mustache templates.
 *
 * @author Pedro Pereira <pedro@propertyguru.com.sg>
 *
 */
class MustacheEngine implements EngineInterface
{
    protected $extensions;
    protected $mustache;
    protected $tempalteNameParser;

    public function __construct(Mustache $mustache, TemplateNameParserInterface $tempalteNameParser)
    {
        $this->mustache  = $mustache;
        $this->tempalteNameParser = $tempalteNameParser;
        // "mustache" as the default extension for mustache templates
        $this->extensions = array('mustache');
    }

    public function render($name, array $parameters = array())
    {
        $template = $this->load($name);

        return $template->render($parameters);
    }

    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($this->render($view, $parameters));

        return $response;
    }

    public function exists($name)
    {
        try {
            $this->load($name);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    public function supports($name)
    {
        if ($name instanceof MustacheTemplate) {
            return true;
        }

        $template = $this->tempalteNameParser->parse($name);
        return  in_array($template->get('engine'), $this->extensions);
    }

    protected function load($name)
    {
        if ($name instanceof MustacheTemplate) {
            return $name;
        }

        return $this->mustache->loadTemplate($name);
    }

    public function addExtensions(array $extensions)
    {

        $extensions = array_merge($this->extensions, $extensions);
        $this->extensions = array_unique($extensions);
    }

    public function setTranslationHelpers(TranslatorInterface $translator)
    {
        // To translate static text like {{t}}Hello{{/t}} -> Olá!
        $this->mustache->addHelper('t', function ($string) use ($translator) {
            $string = trim($string);

            if (false !== strpos($string, '{{!')) {
                $string = trim(substr(strstr($string, '}}', true), 3));
            }

            return $translator->trans($string);
        });

        // {{IWillBeAString}} Holding "Hello"
        // To translate dynamic text like {{T}}{{IWillBeAString}}{{/T}} -> Olá!
        $this->mustache->addHelper('T', function ($string, $mustache) use ($translator) {
            $string = trim($string);

            if (false !== strpos($string, '{{!')) {
                $string = trim(substr(strstr($string, '}}', true), 3));
            }

            return $translator->trans($mustache->render($string));
        });
    }

    public function addHelper(MustacheHelperInterface $helper)
    {
        $this->mustache->addHelper($helper->getName(), $helper->getHelper());
    }
}
