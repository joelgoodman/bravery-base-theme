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

function brvry_enqueue_jquery_in_footer( &$scripts ) {

    if ( ! is_admin() )
        $scripts->add_data( 'jquery', 'group', 1 );
}
add_action( 'wp_default_scripts', 'brvry_enqueue_jquery_in_footer' );

//to add defer to loading of scripts - use defer to keep loading order
function brvry_script_tag_defer($tag, $handle) {
    if (is_admin()){
        return $tag;
    }
    if (strpos($tag, '/wp-includes/js/jquery/jquery')) {
        return $tag;
    }
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !==false) {
    return $tag;
    }
    else {
        return str_replace(' src',' defer src', $tag);
    }
}
add_filter('script_loader_tag', 'brvry_script_tag_defer',10,2);


function brvry_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	// Site name body class
	$site_name = get_bloginfo( 'name' );
	//Lower case everything
	$string = strtolower($site_name);
	//Make alphanumeric (removes all other characters)
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	//Clean up multiple dashes or whitespaces
	$string = preg_replace("/[\s-]+/", " ", $string);
	//Convert whitespaces and underscore to dash
	$string = preg_replace("/[\s_]/", "-", $string);
	$sitename = 'site-' . $string;

	if ( isset($sitename) ) {
		$classes[] = $sitename;
	}

	return $classes;
}
add_filter( 'body_class', 'brvry_body_classes' );

function brvry_post_classes( $classes ) {
	if ( is_single() || is_page() ) {
		global $post;
		$slug = $post->post_name;
		$classes[] = 'post-' . $slug;
	}

	return $classes;
}
add_filter( 'post_class', 'brvry_post_classes' );

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

// Custom Login Styles
function brvry_login_stylesheet() {
    wp_enqueue_style( 'brvry-login', get_template_directory_uri() . '/assets/css/bravery-login.css' );
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
	echo '<a href="http://braverymedia.co/?ref=ctheme" title="Website by Bravery" target="_blank">Website by Bravery.</a>';
}
add_filter('admin_footer_text', 'brvry_admin_footer');

// enable html markup in user profiles
remove_filter('pre_user_description', 'wp_filter_kses');

// admin link for all settings
function brvry_all_settings_link() {
	add_theme_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'brvry_all_settings_link');

// Remove paragraphs from img or iframes
function brvry_filter_ptags_on_images($content) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
// add_filter('the_content', 'brvry_filter_ptags_on_images');

// Allow SVG Uploads
function brvry_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'brvry_mime_types');