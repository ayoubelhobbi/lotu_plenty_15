<?php

namespace LotuTheme\Providers;


use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ComponentContainer;
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
      $dispatcher->listen('IO.init.templates', function(Partial $partial)
			 {
					$partial->set('footer', 'LotuTheme::ThemeFooter');
			 }, 0);

       $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
			 {
					 if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
					 {
							 $container->setNewComponentTemplate('LotuTheme::Item.SingleItem');
					 }
			 }, self::PRIORITY);
    }
}
