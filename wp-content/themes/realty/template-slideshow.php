<?php get_header();
/*
Template Name: Slideshow (obsolete)
*/
?>

<div class="container">
	<p class="alert alert-danger"><?php esc_html_e( 'Page template "Slideshow" is no longer supported in Realty 3.0. Please use page template "Default Template" instead and insert shortcode "Property Slider".', 'realty' ); ?></p>
</div>

<div class="container">
	<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		endif;
	?>
</div>

<?php get_footer(); ?>