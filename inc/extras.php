<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package brvry
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function brvry_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'brvry_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function brvry_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'brvry' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'brvry_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function brvry_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'brvry_render_title' );
endif;

// Automatically load favicons in the theme folder
function brvry_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon.ico" />';
	echo '<link rel="apple-touch-icon" sizes="57x57" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-57x57.png">';
	echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-114x114.png">';
	echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-72x72.png">';
	echo '<link rel="apple-touch-icon" sizes="144x144" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-144x144.png">';
	echo '<link rel="apple-touch-icon" sizes="60x60" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-60x60.png">';
	echo '<link rel="apple-touch-icon" sizes="120x120" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-120x120.png">';
	echo '<link rel="apple-touch-icon" sizes="76x76" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-76x76.png">';
	echo '<link rel="apple-touch-icon" sizes="152x152" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-152x152.png">';
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/apple-touch-icon-180x180.png">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-192x192.png" sizes="192x192">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-160x160.png" sizes="160x160">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-96x96.png" sizes="96x96">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-16x16.png" sizes="16x16">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-32x32.png" sizes="32x32">';
	echo '<meta name="msapplication-TileColor" content="#2c2c2c">';
	echo '<meta name="msapplication-TileImage" content="' . get_stylesheet_directory_uri() . '/assets/img/favicons/mstile-144x144.png">';
}
add_action('wp_head', 'brvry_favicon');


// Adds your favicon to the admin.
function brvry_admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon.ico" />';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-192x192.png" sizes="192x192">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-160x160.png" sizes="160x160">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-96x96.png" sizes="96x96">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-16x16.png" sizes="16x16">';
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/assets/img/favicons/favicon-32x32.png" sizes="32x32">';
}
add_action('admin_head', 'brvry_admin_favicon');

// Custom Login Styles
function brvry_login_stylesheet() {
    wp_enqueue_style( 'brvry-login', get_template_directory_uri() . '/assets/css/brvry-login.css' );
}
add_action( 'login_enqueue_scripts', 'brvry_login_stylesheet' );

// Edit login page logo url
function brvry_login_logo_url() {
	return 'http://braverymedia.co';
}
add_filter('login_headerurl', 'brvry_login_logo_url');

function brvry_login_logo_tooltip() {
	return 'Site by Bravery Media';
}

// customize admin footer text
function brvry_admin_footer() {
	echo '<a href="http://braverymedia.co/?ref=ctheme" title="Website by Bravery Transmedia" target="_blank">Website by Bravery Media</a>';
}
add_filter('admin_footer_text', 'brvry_admin_footer');

// enable html markup in user profiles
remove_filter('pre_user_description', 'wp_filter_kses');

// admin link for all settings
function brvry_all_settings_link() {
	add_theme_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'brvry_all_settings_link');