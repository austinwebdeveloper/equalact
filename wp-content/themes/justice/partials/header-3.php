<?php global $post, $tpath_options; 
$object_id = get_queried_object_id();

if( ( get_option('show_on_front') && get_option('page_for_posts') && is_home() ) || 
( get_option('page_for_posts') && is_archive() && ! is_post_type_archive() ) && 
!( is_tax('product_cat') || is_tax('product_tag') ) || 
( get_option('page_for_posts') && is_search() ) ) {

	$post_id = get_option('page_for_posts');		
} else {
	if( isset($object_id) ) {
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
$header_top_bar = '';
$header_top_bar 	= get_post_meta( $post_id, 'tpath_show_header_top_bar', true );
if( isset( $header_top_bar ) && ( $header_top_bar == '' || $header_top_bar == 'default' ) ) {
	$header_top_bar = $tpath_options['tpath_enable_header_top_bar'];
	if( $header_top_bar == 1 ) {
		$header_top_bar = 'yes';
	} else {
		$header_top_bar = 'no';
	}
} ?>

<?php if ( isset($header_top_bar) && $header_top_bar == 'yes' ) { ?>
<div id="header-top-bar" class="header-top-section navbar">				
	<div class="container">
		<!-- ==================== Toggle Icon ==================== -->
		<div class="navbar-header nav-respons">
			<button type="button" aria-expanded="false" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".tpath-topnavbar-collapse">
				<span class="sr-only"><?php esc_html_e('Toggle navigation', 'Templatepath'); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="navbar-collapse tpath-topnavbar-collapse collapse">
			<!-- ==================== Header Top Bar Left ==================== -->
			<ul class="nav navbar-nav tpath-top-left">
				<li>
				<?php if( isset( $tpath_options['tpath_welcome_msg']) && $tpath_options['tpath_welcome_msg'] != '' ) { ?>
					<p class="welcome-msg"><?php echo force_balance_tags( $tpath_options['tpath_welcome_msg'] ); ?></p>
				<?php } ?>
				</li>
			</ul>
		
			<!-- ==================== Header Top Bar Right ==================== -->
			<ul class="nav navbar-nav navbar-right tpath-top-right">
				<li><?php justice_header_content_area( 'top-navigation' ); ?></li>
			</ul>
		</div>
	</div><!-- .container -->
</div>
<?php } ?>

<div id="header-main" class="header-main-section navbar">
	<div class="container">
		<?php get_template_part( 'partials/header', 'logo' ); ?>

		<div class="navbar-collapse tpath-mainnavbar-collapse collapse tpath-header-main-bar">
			<ul class="nav navbar-nav tpath-main-bar">
				<li class="header-menu-nav"><?php justice_header_content_area( 'main-navigation' ); ?></li>
				
				<?php if ( isset( $tpath_options['tpath_enable_search_in_header']) && $tpath_options['tpath_enable_search_in_header'] == 1 ) { ?>
				<li class="extra-nav search-nav"><?php justice_header_content_area( 'search-box' ); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- .container -->
</div><!-- .header-main-section -->