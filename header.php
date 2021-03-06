<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package brvry
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header id="masthead" class="site-header primary" role="banner">
	<div class="site-branding">
		<?php if ( is_front_page() ) { ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php } else { ?>
			<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
		<?php } ?>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
	</div><!-- .site-branding -->

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Site Menu', 'brvry' ); ?></button>
		<?php wp_nav_menu( array( 'theme_location' => 'site-menu', 'container' => 'nav', ) ); ?>
	</nav><!-- #site-navigation -->
</header><!-- #masthead -->
<section id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'brvry' ); ?></a>

	<div id="content" class="site-content">
