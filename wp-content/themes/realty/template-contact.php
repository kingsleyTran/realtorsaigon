<?php get_header();
/*
Template Name: Contact (obsolete)
*/
?>

<div class="container">
	<p class="alert alert-danger"><?php esc_html_e( 'Page template "Contact" is no longer supported in Realty 3.0. Please use page template "Default Template" instead and insert shortcode "Contact Form" or "Contact Form 7".', 'realty' ); ?></p>
</div>

<?php
// Check Contact Theme Option for Googe Maps Visibility
//if ( isset( $realty_theme_option['contact-google-map'] ) && $realty_theme_option['contact-google-map'] ) {
?>

	<?php while ( have_posts() ) : the_post(); ?>
		<div class="container">
			<?php tt_page_banner(); ?>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>

<?php //} ?>

<?php get_footer(); ?>