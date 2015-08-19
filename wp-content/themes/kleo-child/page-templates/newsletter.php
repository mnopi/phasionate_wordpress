<?php
/**
 * Template Name: Newsletter
 *
 * Description: Newsletter
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
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
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta name="verification" content="6c2c0d0251a189774a6fe4252ce561a5" /><!-- Código de verifiación para zanox -->
    <meta name="inmobi-site-verification" content="fa3318c03e3cc17de5c28334685b8964" /><!-- Código de verificación para inmobi -->
    <link href='http://fonts.googleapis.com/css?family=Expletus+Sans' rel='stylesheet' type='text/css'>
    
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

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-before-wrap-no-title'); ?>

<?php
if ( have_posts() ) :
    // Start the Loop.
    while ( have_posts() ) : the_post();

        /*
         * Include the post format-specific template for the content. If you want to
         * use this in a child theme, then include a file called called content-___.php
         * (where ___ is the post format) and that will be used instead.
         */
        get_template_part( 'content', 'page' );
        ?>

    <?php endwhile;

endif;
?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>