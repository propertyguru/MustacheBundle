<?php

namespace Propertyguru\MustacheBundle\Helper;

/**
 * To resolve url encoded by Symfony router generate
 * using
 * create service with tags to mustache.helper service
 * templating_url_decode_helper
 *       class: Propertyguru\MustacheBundle\Helper\UrlDecodeHelper
 *       tags:
 *           - { name: mustache.helper, alias: url_decode_helper }
 *
 *  {{#url_decode}}{{ urlEncode }}{{/url_decode}}
 */
class UrlDecodeHelper implements MustacheHelperInterface
{
    /**
    * @return helper section name
    */
    public function getName()
    {
        return 'url_decode';
    }

    /**
     * @return Closure to Render a string as a Mustache template with the current rendering context.
     * string Rendered template.
     */
    public function getHelper()
    {
        /**
         * @param string $string
         * @param Mustache_Engine $mustache
         */
        return function($url, $mustache) {

            $url = trim($url);

            if (false !== strpos($url, '{{!')) {
                $url = trim(substr(strstr($url, '}}', true), 3));
            }

            return rawurldecode($mustache->render($url));
        };
    }
}
