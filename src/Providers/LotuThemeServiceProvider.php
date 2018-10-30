<?php

/**
* @author: Ayoub El Hobbi 
*/

namespace LotuTheme\Providers;


use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ComponentContainer;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;

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

      $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
       {
           $container->addScriptTemplate('LotuTheme::ThemeScript');
       }, self::PRIORITY);

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

       $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'LotuTheme::ResultFields.SingleItemWrapper'
      ]);
     }, 0);

     $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem')
     {
        $container->setNewComponentTemplate('LotuTheme::ItemList.Components.CategoryItem');
     }
      }, self::PRIORITY);

        /* ListItem JSON überschreiben */
    $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_LIST_ITEM   => 'LotuTheme::ResultFields.ListItem'
      ]);
    }, 0);

        /* Testing */
    $dispatcher->listen('IO.tpl.category.content', function(TemplateContainer $container)
				{
					$container->setTemplate('LotuTheme::Category.Item.Partials.CategoryListItem');
					return false;
				}, 0);

        /* Überschreiben der ItemImageCarousel */
    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
    if( $container->getOriginComponentTemplate() == 'Ceres::Item.Components.ItemImageCarousel')
    {
       $container->setNewComponentTemplate('LotuTheme::Item.ItemImageCarousel');
    }
     }, self::PRIORITY);

    }
}
