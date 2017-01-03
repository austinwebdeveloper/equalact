<?php
/**
 * The Header for our theme.
 *
 * Displays all of the header section
 *
 * @package TemplatePath
 */

global $tpath_options;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
	<!-- Latest IE rendering engine & Chrome Frame Meta Tags -->
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if( isset( $tpath_options['tpath_disable_page_loader'] ) && $tpath_options['tpath_disable_page_loader'] != 1 ) { ?>	
	<div class="pageloader"></div>
<?php } ?>

<div id="tpath_wrapper" class="wrapper-class">

	<?php 
	$object_id = get_queried_object_id();
	
	if( ( get_option('show_on_front') && get_option('page_for_posts') && is_home() ) || ( get_option('page_for_posts') && is_archive() && ! is_post_type_archive() ) 
	&& ! ( is_tax('product_cat') || is_tax('product_tag' ) ) || ( get_option('page_for_posts') && is_search() ) ) {
		$post_id = get_option('page_for_posts');		
	} else {
		if( isset( $object_id ) ) {
			$post_id = $object_id;
		}

		if( class_exists('Woocommerce') ) {
			if( is_shop() ) {
				$post_id = get_option('woocommerce_shop_page_id');
			}
		}
		if ( ! is_singular() ) {
			$post_id = false;
		}
	} 
	
	$header_transparency 	= '';
	$header_transparency 	= get_post_meta( $post_id, 'tpath_header_transparency', true );
	if( isset( $header_transparency ) && $header_transparency == '' || $header_transparency == 'default' ) {
		$header_transparency = $tpath_options['tpath_header_transparency'];
	}
	
	if( ! $header_transparency ) {
		$header_transparency  = "no-transparent";
	} ?>
	
	<div id="header" class="header-section htype-<?php echo esc_attr( $tpath_options['tpath_header_type'] ); ?> header-<?php echo esc_attr( $header_transparency ); ?>">
		<?php get_template_part('partials/'. $tpath_options['tpath_header_type'] ); ?>
	</div><!-- #header -->
	
	<div id="section-top" class="tpath-section-top"></div>	
	<?php 
	if( is_object($post) ) {	
	
		$revslider_sc = get_post_meta( $post->ID, 'tpath_revslider_shortcode', true );
		if( $revslider_sc != '0' && $revslider_sc != '' && function_exists( 'rev_slider_shortcode' ) ) {
		
			echo '<div class="slider-section">';
				echo do_shortcode($revslider_sc);
			echo '</div>';
			
		}
	}	
	?>
	
	<div id="main" class="main-section">
		<!-- ============ Page Header ============ -->
		<?php get_template_part('partials/page', 'header' ); ?>