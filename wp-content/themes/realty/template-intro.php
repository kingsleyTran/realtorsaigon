<?php get_header();
/*
Template Name: Intro (obsolete)
*/

/*
$facebook = $realty_theme_option['social-facebook'];
$twitter = $realty_theme_option['social-twitter'];
$google = $realty_theme_option['social-google'];
$linkedin = $realty_theme_option['social-linkedin'];
$pinterest = $realty_theme_option['social-pinterest'];
$instagram = $realty_theme_option['social-instagram'];
$youtube = $realty_theme_option['social-youtube'];
$skype = $realty_theme_option['social-skype'];
*/
?>

<div class="container">
	<p class="alert alert-danger"><?php esc_html_e( 'Page template "Intro" is no longer supported in Realty 3.0. Please use page template "Default Template" instead and insert one of the Visual Composer "Intro" templates.', 'realty' ); ?></p>
</div>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
		$post_featured_image_id = get_post_thumbnail_id();
		$post_featured_image = wp_get_attachment_image_src( $post_featured_image_id, 'full', true );
		$intro_slideshow_images = get_post_meta( get_the_ID(), 'estate_intro_fullscreen_background_slideshow_images', false );

		$slides_loop = 1;
		if ( count( $intro_slideshow_images ) == 1 ) {
		  $slides_loop = 0;
		}

		$intro_video_provider = get_post_meta( get_the_ID(), 'estate_intro_fullscreen_background_video_provider', true );
		$intro_video_id = get_post_meta( get_the_ID(), 'estate_intro_fullscreen_background_video_id', true );
		$intro_video_audio = get_post_meta( get_the_ID(), 'estate_intro_fullscreen_background_video_audio', true );

		// Show featured image, if there are no slideshow images
		if ( has_post_thumbnail() && tt_is_array_empty( $intro_slideshow_images ) ) {
			$featured_image = 'style="background-image:url(' . $post_featured_image[0] . '"';
		} else {
			$featured_image = null;
		}
	?>

	<div id="intro-wrapper" <?php echo $featured_image; ?>>

		<?php if ( $intro_slideshow_images && ( $intro_video_provider == 'none' || ! $intro_video_id ) ) { ?>
			<div id="intro-background-images">
				<?php
					$args = array(
						'post_type' => 'attachment',
						'orderby' => 'post__in',
						'post__in' => $intro_slideshow_images,
						'posts_per_page' => count($intro_slideshow_images)
					);

					$gallery_array = get_posts( $args );
				?>

				<?php	foreach ($gallery_array as $slide) { ?>
					<?php $attachment = wp_get_attachment_image_src( $slide->ID, 'full' ); ?>
					<div class="background-image" style="background-image:url(<?php echo $attachment[0]; ?>)"></div>
				<?php }	?>
			</div>
		<?php }	?>

		<div class="wrapper">
			<div class="inner">

				<?php if ( $intro_video_id && ( $intro_video_provider == "youtube" || $intro_video_provider == "vimeo" ) ) { ?>

					<?php
						if ( $intro_video_provider == 'youtube' ) {
							if ( is_ssl() ) {
								$intro_video_url = 'https://youtube.com/embed/' . $intro_video_id;
							} else {
								$intro_video_url = 'http://youtube.com/embed/' . $intro_video_id;
							}
							echo '<iframe width="1280" height="720" src="' . $intro_video_url . '?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>';
						}

						if ( $intro_video_provider == 'vimeo' ) {
							if ( is_ssl() ) {
								$intro_video_url = 'https://player.vimeo.com/video/' . $intro_video_id . '?autoplay=1';
							} else {
								$intro_video_url = 'http://player.vimeo.com/video/' . $intro_video_id . '?autoplay=1';
							}
							/*
							require_once( ABSPATH . WPINC . '/class-oembed.php' );
							$oembed = _wp_oembed_get_object();

							$url_video = $oembed->get_html( $intro_video_url );
							*/

							echo '<div class="fluid-width-video-wrapper"><iframe src="'.$intro_video_url.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
						}
					?>

				<?php } // IF video	?>

				<div class="intro-bg-left"></div>
				<div class="intro-bg-right"></div>

				<div class="container">

					<div class="col-sm-6 intro-content-left">
						<?php the_content(); ?>
					</div>

					<div class="col-sm-6 intro-content-right">
						<div class="intro-search">
							<div class="intro-title">
								<h4 class="title"><?php _e( 'Property Search', 'realty' ); ?></h4>
								<a href="#" class="toggle"><?php _e( 'Show Map', 'realty' ); ?></a>
							</div>
							<?php get_template_part( 'lib/inc/template/search-form' ); ?>
						</div>
						<div class="intro-map transform">
							<div class="intro-title">
								<h4 class="title"><?php _e( 'Property Map', 'realty' ); ?></h4>
								<a href="#" class="toggle"><?php _e( 'Show Search', 'realty' ); ?></a>
							</div>
							<?php get_template_part( 'lib/inc/template/google-map-multiple-properties' ); ?>
						</div>
					</div>

				</div>

			</div>
		</div>

	<a href="#" id="toggle-intro-wrapper"><i class="icon-expand"></i></a>

	<?php if ( $intro_slideshow_images ) { ?>
		<script>
			jQuery(document).ready(function() {

			  // Intro Carousel
				jQuery('#intro-background-images').owlCarousel({
					<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
					rtl: true,
					<?php } ?>
				  items: 1,
				  lazyLoad: true,
				  loop: <?php echo $slides_loop ; ?>,
				  margin: 0,
				  dots: false,
				  nav: false,
				  autoplay: true,
					animateIn: 'fadeIn',
					animateOut: 'fadeOut',
				});

			});
		</script>
	<?php } ?>

<?php endwhile; ?>

<?php get_footer(); ?>