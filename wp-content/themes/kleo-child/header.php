<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script>
		document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';
	</script>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta name="verification" content="6c2c0d0251a189774a6fe4252ce561a5" /><!-- Código de verifiación para zanox -->
	<!-- Fav and touch icons -->
	<?php if (sq_option_url('favicon')) { ?>
	<link rel="shortcut icon" href="<?php echo sq_option_url('favicon'); ?>">
	<?php } ?>
	<?php if (sq_option_url('apple57')) { ?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo sq_option_url('apple57'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple72')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo sq_option_url('apple72'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple114')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo sq_option_url('apple114'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple144')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo sq_option_url('apple144'); ?>">
	<?php } ?>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontello-ie7.css">
	<![endif]-->

	<?php if(function_exists('bp_is_active')) { bp_head(); } ?>
	<script type='text/javascript'>
		var googletag = googletag || {};
		googletag.cmd = googletag.cmd || [];
		(function() {
			var gads = document.createElement('script');
			gads.async = true;
			gads.type = 'text/javascript';
			var useSSL = 'https:' == document.location.protocol;
			gads.src = (useSSL ? 'https:' : 'http:') +
				'//www.googletagservices.com/tag/js/gpt.js';
			var node = document.getElementsByTagName('script')[0];
			node.parentNode.insertBefore(gads, node);
		})();
	</script>

	<script type='text/javascript'>
		googletag.cmd.push(function() {
			var width = window.innerWidth || document.documentElement.clientWidth;
			if (width >= 1635) {
				googletag.defineSlot('/61601326/u_lateral_derecho', [300, 600], 'div-gpt-ad-1457625928117-1').addService(googletag.pubads());
				googletag.defineSlot('/61601326/u_lateral_izquierdo', [300, 600], 'div-gpt-ad-1457625928117-2').addService(googletag.pubads());
				jQuery("#div-gpt-ad-1457722273425-0").hide();
				jQuery("#div-gpt-ad-1457722273425-1").hide();
			}
			if (width >= 1238 && width <= 1635) {
				googletag.defineSlot('/61601326/u_lateral_derecho_pequeño', [120, 600], 'div-gpt-ad-1457722273425-0').addService(googletag.pubads());
				googletag.defineSlot('/61601326/u_lateral_izquierda_pequeño', [120, 600], 'div-gpt-ad-1457722273425-1').addService(googletag.pubads());
				jQuery("#div-gpt-ad-1457625928117-1").hide();
				jQuery("#div-gpt-ad-1457625928117-2").hide();
			}
			if (width >= 991 && width <= 1237) {
				googletag.defineSlot('/61601326/cabecera', [970, 90], 'div-gpt-ad-1457985102265-0').addService(googletag.pubads());
				var ls = document.createElement('link');
				ls.rel="stylesheet";
				ls.href="/wp-content/themes/kleo-child/assets/css/cabecera_ad.css";
				document.getElementsByTagName('head')[0].appendChild(ls);
			}
			if (width <= 990){
				googletag.defineSlot('/61601326/mayor', [300, 600], 'div-gpt-ad-1457972362060-0').addService(googletag.pubads());
			}
			googletag.pubads().enableSingleRequest();
			googletag.enableServices();
		});
	</script>
	<meta name="p:domain_verify" content="fd4dd19485ea9f51eccc6866100da866"/> <!-- pinterest -->
	<?php wp_head(); ?>
</head>

<?php 
/***************************************************
:: Some header customizations
***************************************************/

$site_style = sq_option('site_style', 'wide') == 'boxed' ? ' page-boxed' : '';
$site_style = apply_filters('kleo_site_style', $site_style);
?>

<body <?php body_class(); ?>>
	
	<?php do_action('kleo_after_body');?>
	
	<!-- PAGE LAYOUT
	================================================ -->
	<!--Attributes-->
	<div class="kleo-page<?php echo $site_style;?>">


	<!-- HEADER SECTION
	================================================ -->
	<?php 
	/**
	 * Header section
	 * @hooked kleo_show_header
	 */
	do_action('kleo_header');
	?>
	
	<!-- MAIN SECTION
	================================================ -->
	<div id="main">

	<?php 
	/**
	 * Hook into this action if you want to display something before any Main content
	 * 
	 */
	do_action('kleo_before_main');
	?>

	<?php if (!wp_is_mobile()){ ?>
		<div id="ads_container">
			<!-- /61601326/cabecera -->
			<div id='div-gpt-ad-1457985102265-0' style='height:90px; width:970px; top: 0 !important;margin: 0px 0px;position: fixed;visibility: hidden;'>
				<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1457985102265-0'); });
				</script>
			</div>
			<!-- /61601326/u_lateral_derecho -->
			<div id='div-gpt-ad-1457625928117-1' style='height:600px; width:300px;position: fixed;right: 0;z-index: 0;margin-top: 24px;'>
				<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1457625928117-1'); });
				</script>
			</div>
			<!-- /61601326/u_lateral_izquierdo -->
			<div id='div-gpt-ad-1457625928117-2' style='height:600px; width:300px; position: fixed; left: 0;margin-top: 24px;'>
				<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1457625928117-2'); });
				</script>
			</div>
			<!-- /61601326/u_lateral_derecho_pequeño -->
			<div id='div-gpt-ad-1457722273425-0' style='height:600px; width:120px;position: fixed;right: 0;z-index: 0;margin-top: 24px;'>
				<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1457722273425-0'); });
				</script>
			</div>
			<!-- /61601326/u_lateral_izquierda_pequeño -->
			<div id='div-gpt-ad-1457722273425-1' style='height:600px; width:120px; position: fixed; left: 0;margin-top: 24px;'>
				<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1457722273425-1'); });
				</script>
			</div>
		</div>
	<?php } ?>
		