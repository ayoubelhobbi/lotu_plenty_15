<?php

namespace LotuTheme\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use IO\Helper\TemplateContainer;

/**
 * Class LotuThemeServiceProvider
 * @package LotuTheme\Providers
 */
class LotuThemeServiceProvider extends ServiceProvider
{
    const PRIORITY = 0;

    public function register()
    {
        
    }

    public function boot(Dispatcher $dispatcher)
    {
       	// Override template
        $dispatcher->listen('IO.tpl.home', function (TemplateContainer $container) {
            $container->setTemplate('LotuTheme::Homepage.Homepage');
            return false;
        }, self::PRIORITY);
    }
}