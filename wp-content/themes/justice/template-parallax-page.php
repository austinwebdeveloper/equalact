<?php global $post;

$post_id = get_the_ID();
$post_name = $post->post_name;

$overlay_class = $parallax_class = '';

// Get Parallax Options
$tpath_section_header_status = get_post_meta( $post_id, 'tpath_section_header_status', true );
$tpath_section_title = get_post_meta( $post_id, 'tpath_section_title', true );
$tpath_section_slogan = get_post_meta( $post_id, 'tpath_section_slogan', true);
$tpath_parallax_status = get_post_meta( $post_id, 'tpath_parallax_status', true);
$tpath_parallax_bg_overlay = get_post_meta( $post_id, 'tpath_parallax_bg_overlay', true);
$tpath_overlay_pattern_status = get_post_meta( $post_id, 'tpath_overlay_pattern_status', true);
$tpath_section_overlay_color = get_post_meta( $post_id, 'tpath_section_overlay_color', true);
$tpath_overlay_pattern_style = get_post_meta( $post_id, 'tpath_overlay_pattern_style', true);
if( $tpath_parallax_bg_overlay == 'yes' && $tpath_overlay_pattern_status == 'yes' ) {
	$overlay_class = ' ' . $tpath_overlay_pattern_style . ' parallax-overlay';
}							
if( $overlay_class != '' && $tpath_overlay_pattern_style != '' ) {
	$overlay_class .= ' parallax-overlay-pattern';
}
if( $overlay_class != '' && $tpath_section_overlay_color != '' ) {
	$overlay_class .= ' parallax-overlay-color';
}

if( $tpath_parallax_status == 'yes') {
	$parallax_class = ' parallax-background parallax-section';
} else {
	$parallax_class = ' normal-background';
} ?>

<div id="section-<?php echo esc_attr( $post_name ); ?>" class="page-id-<?php echo esc_attr( $post_id ); ?> page-<?php echo esc_attr( $post_name ); ?> fullwidth-section section-page <?php echo esc_attr($parallax_class); ?><?php echo esc_attr($overlay_class); ?>">
	<div id="page-<?php echo esc_attr( $post_name ); ?>" class="parallax-page-inner">
		
		<?php if( $tpath_section_header_status == 'show' && ( $tpath_section_title != '' || $tpath_section_slogan != '' ) ) { ?>
			<div class="container tpath-parallax-header">
				<div class="parallax-header">
					<h2 class="parallax-title"><?php echo do_shortcode( $tpath_section_title ); ?></h2>
					<?php if( !empty($tpath_section_slogan) ) { ?>
						<div class="parallax-desc"><?php echo do_shortcode( $tpath_section_slogan ); ?></div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<div class="entry-content parallax-content">
			<?php the_content(); ?>
		</div>
				
	</div>
</div>