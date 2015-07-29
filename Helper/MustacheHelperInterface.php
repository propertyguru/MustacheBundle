<?php

namespace Propertyguru\MustacheBundle\Helper;

/**
 *
 */
interface MustacheHelperInterface
{
    /**
    * @return helper section name
    */
    public function getName();

    /**
     * @return Closure to Render a string as a Mustache template with the current rendering context.
     * string Rendered template.
     */
    public function getHelper();
}
