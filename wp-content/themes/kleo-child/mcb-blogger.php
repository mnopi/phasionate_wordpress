<?php
/**
 * Template Name: Blogger Marilyn's Closet Blog (mcb)
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1, minimum-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
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
	<!-- Estilos Iframe -->
	<style>
        body{
            margin: 0;
			height: 100%;
			position:absolute;
			left:0 !important;
        }
		#main{
			min-height: 100%;
		}
		iframe{ 
			width:100%;
			height:100%;
			border: 0;
			display:block;
		}
	</style>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontello-ie7.css">
	<![endif]-->
	
	<?php if(function_exists('bp_is_active')) { bp_head(); } ?>	
	<script>
		document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';
	</script>	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	/* HEADER */
	if (!is_front_page() ): do_action('kleo_header');
	endif;

	/* BREAD CRUMBS */
		$title_arr['show_title'] = false;
		$title_arr['show_breadcrumb'] = true;
		$title_arr['extra'] = '';
		echo kleo_title_section( $title_arr );
	?>
	

	<iframe src="http://marilynsclosetblog.blogspot.com.es/" frameborder="0"></iframe>	
	<!-- FOOTER -->
	<?php get_sidebar('footer');?>
	<!-- Analytics -->
	<?php echo sq_option('analytics', ''); ?>
	
	<?php
		/* FOOTER */
			wp_footer(); 		 
				/**
				 * After footer hook
				 * @hooked kleo_go_up
				 * @hooked kleo_show_contact_form
				 */
			do_action('kleo_after_footer');  //go_up + socket En phasionate dividido por problemas con la home().
	?>
</body>
</html>