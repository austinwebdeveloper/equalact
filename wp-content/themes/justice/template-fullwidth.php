<?php
/**
 * Template Name: Fullwidth Template
 *
 * The fullwidth page template to display fullwidth section and VC Row to fullwidth
 *
 * @package TemplatePath 
 */
 
global $tpath_options;
get_header(); ?>

<?php if ( have_posts() ):
	while ( have_posts() ): the_post(); 
	
		$page_content_block 	= get_post_meta( $post->ID, 'tpath_additional_content_block', true ); ?>
	
		<div class="fullwidth-page-wrapper">
			<?php the_content(); ?>
			
			<?php if( isset( $page_content_block ) && ( $page_content_block != '' && $page_content_block != 0 ) ) {
				echo justice_block( $page_content_block );
			} ?>
		</div>
		
	<?php endwhile;
endif; ?>

<?php get_footer(); ?>