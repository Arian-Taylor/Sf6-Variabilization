<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Object\CustomTranslationObject;

class AppExtension extends AbstractExtension
{
    private $container;

    public function __construct(
        $container
    ){
        $this->container = $container;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('routeExists', [$this, 'routeExists']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('customTranslate', [$this, 'customTranslate']),
            new TwigFunction('getEntryPointThemeOfSite', [$this, 'getEntryPointThemeOfSite']),
            new TwigFunction('getSystemSiteVariabilization', [$this, 'getSystemSiteVariabilization']),
        ];
    }

    function routeExists($name)
    {
        $router = $this->container->get('router');
        return (null === $router->getRouteCollection()->get($name)) ? false : true;
    }

    /**
     * 
     * @param string $key
     * @param [] $params
     * @return string
     */
    function customTranslate($key, $params=[])
    {
        $result = CustomTranslationObject::customTranslate($key, $params) ;
        return $result ;
    }

    /**
     * 
     * @return string
     */
    function getEntryPointThemeOfSite()
    {
        $result = CustomTranslationObject::getEntryPointThemeOfSite() ;
        return $result ;
    }

    /**
     * 
     * @return string
     */
    function getSystemSiteVariabilization()
    {
        $result = CustomTranslationObject::getSystemSiteVariabilization() ;
        return $result ;
    }
}