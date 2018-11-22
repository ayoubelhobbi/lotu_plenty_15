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
          /* Skripte einbinden  */
      $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
       {
           $container->addScriptTemplate('LotuTheme::ThemeScript');
       }, self::PRIORITY);

          /* Footer überschreiben  */
      $dispatcher->listen('IO.init.templates', function(Partial $partial)
			 {
					$partial->set('footer', 'LotuTheme::ThemeFooter');
			 }, 0);

          /* SingleItem überschreiben */
       $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
			 {
					 if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
					 {
							 $container->setNewComponentTemplate('LotuTheme::Item.SingleItem');
					 }
			 }, self::PRIORITY);

          /* ResultFields SingleItemWrapper überschreiben  */
       $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'LotuTheme::ResultFields.SingleItemWrapper'
      ]);
     }, 0);

          /* KategorieAnsicht bei Auswahl der Navigation überschreiben  */
     $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem')
     {
        $container->setNewComponentTemplate('LotuTheme::ItemList.Components.CategoryItem');
     }
      }, self::PRIORITY);


      /* KategorieAnsicht bei Standard Kategorie */


        /* ListItem JSON überschreiben */
    $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_LIST_ITEM   => 'LotuTheme::ResultFields.ListItem'
      ]);
    }, 0);

        /* Überschreiben der ItemImageCarousel */
    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
    if( $container->getOriginComponentTemplate() == 'Ceres::Ceres::Item.Components.ItemImageCarousel')
    {
       $container->setNewComponentTemplate('LotuTheme::Item.ItemImageCarousel');
    }
     }, self::PRIORITY);

     /* Überschreiben der ShippingProfileSelect */
   $dispatcher->listen('tpl.checkout', function(ComponentContainer $container){
   if( $container->getOriginComponentTemplate() == 'Ceres::Item.Components.ShippingProfileSelect')
   {
      $container->setNewComponentTemplate('LotuTheme::Checkout.Components.ShippingProfileSelect');
   }
    }, self::PRIORITY);


    }
}
