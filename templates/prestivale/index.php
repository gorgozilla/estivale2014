<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.prestivale
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript(JURI::base() . '/templates/' .$this->template. '/javascript/modernizr.js', 'text/javascript');
$doc->addScript(JURI::base() . '/templates/' .$this->template. '/javascript/jquery.cycle2.min.js', 'text/javascript');
$doc->addScript(JURI::base() . '/templates/' .$this->template. '/javascript/jquery.qtip.min.js', 'text/javascript');
$doc->addScript(JURI::base() . '/templates/' . $this->template . '/javascript/jquery.nivo.slider.pack.js', 'text/javascript');

// Add Stylesheets
$doc->addStyleSheet(JURI::base() . '/templates/'.$this->template.'/css/default.css');
$doc->addStyleSheet(JURI::base() . '/templates/'.$this->template.'/css/bootstrap.css');
$doc->addStyleSheet(JURI::base() . '/templates/'.$this->template.'/css/nivo-slider.css');
$doc->addStyleSheet(JURI::base() . '/templates/'.$this->template.'/css/template.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Add current user information
$user = JFactory::getUser();


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<script type="text/javascript">
	$j(function() {
		$j('.slider_prog').nivoSlider({effect:'fold',directionNav: false});
	});
	
	$j(document).ready(function(){
		$j('.slideshow-31').cycle();
		
		// Match all link elements with href attributes within the content div
		$j('.main_content span.vip-info').qtip(
		{
		  content: '<h3>Avantages du VIP</h3><ul><li>Acc&egrave;s &agrave; la terrasse et au bar VIP lors d&rsquo;une des trois soir&eacute;es les 31 juillet, 2 et 3 août (ou lors des 3 soir&eacute;es dans le cas d&#39;un abonnement)</li><li>Acc&egrave;s facilit&eacute; pour l&rsquo;entr&eacute;e &agrave; la manifestation, Parking r&eacute;serv&eacute;</li></ul>' // Give it some content, in this case a simple string
		});
	});
	</script>
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">
	<header>
		<a href="index.php" title="Estivale Open Air | 31 juillet, 01, 02, 03 août | Estavayer-le-Lac">
		<img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/logo_estivale.png'; ?>" alt="Estivale Open Air | 31 juillet, 01, 02, 03 août | Estavayer-le-Lac" class="logo_estivale" />
		</a>
		<div class="header_title">
			<h1 class="title_black">31 juillet</h1>
			<h1 class="yellow_title">01, 02, 03 août</h1>
		</div>
		<h1 class="year_title">20<span class="yellow_year_title">14</span></h1>
		<div class="navbar navbar-fixed-top">
			<jdoc:include type="modules" name="mainmenu" style="xhtml" />
		</div>
		<div id="social_icons">
			<a href="https://www.facebook.com/pages/Estivale-Open-Air/42982238334">
				<img src="<?php echo JURI::base() . '/images/fb_social_icon.png'; ?>" title="Rejoignez-nous sur Facebook!" />
			</a>
			<a href="http://www.youtube.com/channel/UCy7lpjr33eV8MRAqIynRkLw">
			<img src="<?php echo JURI::base() . '/images/youtube_social_icon.png'; ?>" title="Rejoignez-nous sur YouTube!" />
			</a>
		</div>
	</header>

	<div class="slider_container">
		<div class="slider_prog theme-bar">
      <img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/thanks_2015.jpg'; ?>" />
			<a href="index.php/programme/pascal-obispo"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/obispo.jpg'; ?>" /></a>
			<a href="index.php/programme/william-white"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/william_white.jpg'; ?>" /></a>
			<a href="index.php/programme/noa-moon"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/noa_moon.jpg'; ?>" /></a>
			<a href="index.php/programme/the-rambling-wheels"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/the_rambling_wheels.jpg'; ?>" /></a>
			<a href="index.php/programme/dirty-sound-magnet"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/dirty_sound_magnet.jpg'; ?>" /></a>
			<a href="index.php/programme/james-arthur"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/james_arthur.jpg'; ?>" /></a>
			<a href="index.php/programme/jabberwocky"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/jabberwocky.jpg'; ?>" /></a>
			<a href="index.php/programme/as-animals"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/as_animals.jpg'; ?>" /></a>
			<a href="index.php/programme/youssoupha"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/youssoupha.jpg'; ?>" /></a>
			<a href="index.php/programme/method-man-redman"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/methodman_redman.jpg'; ?>" /></a>
			<a href="index.php/programme/coely"><img src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/slider/coely.jpg'; ?>" /></a>
		</div>
	</div>

	<div class="main_content">
		<jdoc:include type="modules" name="pathway" style="xhtml" />
		<?php if ($this->countModules('right_pos')){ ?>
			<div class="left_pos col-lg-8 col-md-12">
		<?php } ?>
		
		<jdoc:include type="component" style="xhtml" />
		
		<?php if ($this->countModules('right_pos')){ ?>
			</div>
		<?php } ?>
		
		<?php if ($this->countModules('right_pos')){ ?>
			<div class="right_pos col-lg-4 visible-lg">
				<h3>Playlist Estivale Open Air 2014</h3>
<iframe src="https://embed.spotify.com/?uri=spotify:user:estivaleopenair:playlist:6kvar3FzBalUaB0n31nN2f" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
				<jdoc:include type="modules" name="right_pos" style="xhtml" />
			</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>
	
	<footer>
		<div id="copyright">
			<a href="index.php"><img width="70" height="50" src="<?php echo JURI::base() . '/templates/'.$this->template.'/images/logo_estivale.png'; ?>" alt="Estivale Open Air | 31 juillet, 01, 02, 03 août | Estavayer-le-Lac" align="left" hspace="5" /></a> © Estivale Open Air
		</div>
		
		<div id="partners">
			<h5>Sponsors & Partenaires</h5>
			<a href="http://www.raiffeisen.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/raiffeisen.gif'; ?>" title="Reiffeisen" /></a>
			<a href="https://www.loro.ch/fr"><img src="<?php echo JURI::base() . 'images/partenaires/logo_loro.gif'; ?>" title="Loterie Romande" /></a>
			<a href="http://www.estavayer-le-lac.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/Estavayer-le-Lac.jpg'; ?>" title="Commune d'Estavayer-le-Lac" /></a>
			<a href="http://www.heinekenswitzerland.com/"><img src="<?php echo JURI::base() . 'images/partenaires/heineken.jpg'; ?>" title="Heineken" /></a>
			<a href="http://www.radiofr.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/radiofr.jpg'; ?>" title="Radio FR" /></a>
			<a href="http://www.laliberte.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/Logo_La_Liberte.gif'; ?>" title="La Liberté" /></a>
			<a href="http://www.groupe-e.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/groupe-e.jpg'; ?>" title="Groupe-e" /></a>
			<a href="http://www.rts.ch/option-musique/"><img src="<?php echo JURI::base() . 'images/partenaires/optionmusique.jpg'; ?>" title="Option Musique" /></a>
			<a href="http://www.jaccoud.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/JaccoudMusic.png'; ?>" title="Jaccoud Music" /></a>
			<a href="http://www.coca-cola.fr/"><img src="<?php echo JURI::base() . 'images/partenaires/Cocacola.jpg'; ?>" title="Coca Cola" /></a>
			<a href="http://www.jl-chardonnens.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/Chardonnens.jpg'; ?>" title="Chardonnens Boissons" /></a>
			<a href="http://www.frigaz.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/frigaz.jpg'; ?>" title="Frigaz" /></a>
			<a href="http://www.takeoffproductions.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/takeoff_productions.jpg'; ?>" title="TAKEOFF PRODUCTIONS" /></a>
			<a href="http://www.mx3.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/mx3.jpg'; ?>" title="MX3" /></a>
			<a href="http://www.hotelduport.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/logo_hrdp.png'; ?>" title="Hôte du Port" /></a>
      <a href="http://www.rtn.ch/"><img src="<?php echo JURI::base() . 'images/partenaires/rtn.jpg'; ?>" title="RTN" /></a>
		</div>

		<div id="contact">
			<h5>Keep in touch</h5>
			<p>
				Case Postale<br />
				1470 Estavayer-le-Lac (FR)<br />
				Suisse<br />
				<a href="mailto:info@estivale.ch">info@estivale.ch</a>
			</p>
			<a href="https://www.facebook.com/pages/Estivale-Open-Air/42982238334">
				<img src="<?php echo JURI::base() . '/images/fb_social_icon.png'; ?>" title="Rejoignez-nous sur Facebook!" />
			</a>
			<a href="http://www.youtube.com/channel/UCy7lpjr33eV8MRAqIynRkLw">
			<img src="<?php echo JURI::base() . '/images/youtube_social_icon.png'; ?>" title="Rejoignez-nous sur YouTube!" />
			</a>
		</div>

		<div id="footer_menu">
			<h5>Navigation rapide</h5>
			<jdoc:include type="modules" name="footermenu" style="xhtml" />
		</div>
		<div style="clear:both;"></div>
	</footer>
	
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-16467406-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
</body>
</html>