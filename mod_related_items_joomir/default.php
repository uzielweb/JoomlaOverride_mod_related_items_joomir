<?php
/**
 * @package      Joomla.Site
 * @subpackage   mod_related_items
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$app = JFactory::getApplication();

$widthchoosen = $params->get('widthchoosen', '360');
$heightchoosen = $params->get('heightchoosen', '240');
$cropchoosen = $params->get('cropchoosen', '4:3');
$tpath = JURI::base(true).'/templates/'.$app->getTemplate().'/';

$modulepath = $tpath.'/html/mod_'.$module->name.'/';
$thumbsnippet = $modulepath.'assets/smart/image.php?width='.$widthchoosen.'&height='.$heightchoosen.'&cropratio='.$cropchoosen.'&image='.JURI::root();

$document = JFactory::getDocument();
$document->addStyleSheet($modulepath.'owlcarousel/owl.carousel.min.css');
$document->addStyleSheet($modulepath.'owlcarousel/owl.theme.default.min.css');
$document->addStyleSheet($modulepath.'assets/style.css');
//$document->addScript($modulepath.'owlcarousel/jquery.min.js');
$document->addScript($modulepath.'owlcarousel/owl.carousel.min.js');
$document->addScriptDeclaration('
jQuery(document).ready(function($){
  $(".owl-carousel").owlCarousel({
	 loop:true,
    margin:10,
    nav:true,
    autoplay: true
   
    
  
  });
});
'); 
?>
<!--<h3 class="paleo_title">Related Items</h3>-->

<div class="owl-carousel">
  
<?php 
$i = 0;
foreach ($list as $item) : { if (++$i > $params->get('maximum')){break ;}   ?>
<?PHP
      // Grab intro text and shorten to length specified below in numwords
  $numwords = 35;
  preg_match("/(\S+\s*){0,$numwords}/", $item->introtext, $regs);
  $shortdesc = trim($regs[0]);
?>



<?php 
      // Use json decode for image object
$image = json_decode($item->images);
 ?>
<div id="paleo-related-wrapper">


<div id="paleo-related-item-with-image" class="relateds">

<span class="related-image">
<a href="<?php echo $item->route; ?>">
<img src="<?php echo $thumbsnippet.$image->{'image_intro'}; ?>" class="related-resize" /></a>
</span>   

<div class="related-link">
<a href="<?php echo $item->route; ?>"><?php echo $item->title; ?></a>
</div>

<!--
<span class="related-text">
<?php echo $shortdesc ; ?>
</span>      
-->
</div>

</div>
<?php 
}      
 endforeach; ?>
</div>
