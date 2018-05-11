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
$widthchoosen = $params->get('widthchoosen', '900');
$heightchoosen = $params->get('heightchoosen', '300');
$cropchoosen = $params->get('cropchoosen', '4:1');
$tpath = JURI::base(true).'/templates/'.$app->getTemplate().'/';
$modulepath = $tpath.'/html/mod_'.$module->name.'/';
$thumbsnippet = $modulepath.'assets/smart/image.php?width='.$widthchoosen.'&height='.$heightchoosen.'&cropratio='.$cropchoosen.'&image='.JURI::root();
$document = JFactory::getDocument();
$document->addStyleSheet($modulepath.'owlcarousel/owl.carousel.min.css');
$document->addStyleSheet($modulepath.'owlcarousel/owl.theme.default.min.css');
$document->addStyleSheet($modulepath.'assets/style.css');
$document->addStyleSheet($modulepath.'assets/animate.css');
//$document->addScript($modulepath.'owlcarousel/jquery.min.js');
$document->addScript($modulepath.'owlcarousel/owl.carousel.min.js');
$document->addScriptDeclaration('
jQuery(document).ready(function($){
$(".owl-carousel").owlCarousel({
loop:true,
margin:10,
nav:true,
autoplay: true,
responsiveClass:true,
responsive:{
0:{
items:1,        
},
600:{
items:3,            
},
1000:{
items:5,
}
}
});
});
'); 
?>

<div class="owl-carousel">
  <?php 
$i = 0;
//arsort é para sortear em ordem reversa do maior para o menor
//$article refere-se a uma variável especial que pega coisas do artigo, pois não foram disponibilizadas plenamente na variável $item. No caso $item->created retornava somente data sem horário e eu queria pegar o horário, por isso instanciei uma nova variável para pegar coisas do artigo chamada $article (poderia ser qualquer nome, coloquei esse por achar mais conveniente no momento)

arsort($list, $article->created);
//aqui começa  a listagem  
foreach ($list as $item) { 
//aqui começa o uso da nova variável $article que pode pegar qualquer coisa dos artigos (funciona como a variável $item, porém mais completa)
  
$article = JTable::getInstance('content');
$article->load($item->id);
// list limit  
if (++$i > $params->get('maximum')){break ;}   

// Grab intro text and shorten to length specified below in numwords
$numwords = 35;
preg_match("/(\S+\s*){0,$numwords}/", $item->introtext, $regs);
$shortdesc = trim($regs[0]);

// Use json decode for image object
$image = json_decode($item->images);
?>
  <div id="paleo-related-wrapper">
    <div id="paleo-related-item-with-image" class="relateds">
      <span class="related-image">
        <a href="<?php echo $item->route; ?>">
          <img src="<?php echo $thumbsnippet.$image->{'image_intro'}; ?>" class="related-resize" />
        </a>
      </span>   
      <div class="related-link">
        <a href="<?php echo $item->route; ?>">
          <?php echo $item->title; ?>
        </a>
      </div>
      <?php if ($params->get('showDate') == '1') : ?>
      <div class="related-date">
<?php 
// aqui o texto está formatado para data (d-m-Y) e hora (H:i:s)
//para colocar assim "2 de janeiro de 2018" altere assim "d \d\e F \d\e Y"

//para colocar assim "2 de janeiro de 2018 às 20:15 h" altere assim "d \d\e F \d\e Y \à\s H:h \h"
  echo JHtml::_('date', $article->created, 'd-m-Y H:i:s'); 
?>
      </div> 
      <?php endif;?>  
      <div class="related-text">
        <?php echo strip_tags($shortdesc) ; ?>
      </div>   
    </div>
  </div>
  <?php 
}      
?>
</div>
