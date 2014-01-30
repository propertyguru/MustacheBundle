<?php

namespace Propertyguru\MustacheBundle\Assetic;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;

class MustacheFormulaLoader implements FormulaLoaderInterface
{
    /**
     * Assetic tries to load stuff from our template engine.
     * We provide a method to prevent warnings
     */
    public function load(ResourceInterface $resource)
    {
        return array();
    }
}