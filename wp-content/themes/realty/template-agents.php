<?php get_header();
/*
Template Name: Agents (obsolete)
*/
global $realty_theme_option;
?>

<div class="container">
	<p class="alert alert-danger"><?php esc_html_e( 'Page template "Agents" is no longer supported in Realty 3.0. Please use page template "Default Template" instead and insert shortcode "Agents".', 'realty' ); ?></p>
</div>

<?php while ( have_posts() ) : the_post(); ?>
	<?php $page_content = get_the_content(); ?>

	<?php if ( ! empty( $page_content ) ) { ?>
		<div id="main-content" class="content-box">
			<?php the_content(); ?>
		</div>
	<?php } ?>
<?php endwhile; ?>

<div class="container">
	<div class="row">

		<?php
			if ( isset( $realty_theme_option['template_agent_order'] ) ) {
				$agents_order = $realty_theme_option['template_agent_order'];
			} else {
				$agents_order = 'desc';
			}

			if ( isset($realty_theme_option['template_agent_orderby'] ) ) {
				$agents_orderby = $realty_theme_option['template_agent_orderby'];
			} else {
				$agents_orderby = 'registered';
			}
		?>

		<?php if ( is_active_sidebar( 'sidebar_agent' ) ) { ?>
			<div class="col-sm-8 col-md-9">
		<?php } else { ?>
			<div class="col-sm-12">
		<?php } ?>

		<?php
			$args_users = array(
				'role'         => 'agent',
				'orderby'      => $agents_orderby ,
				'order'        => $agents_order ,
			);

			$user_query_results = get_users( $args_users );
		?>

		<?php if ( $user_query_results ) { // Display author info only, if user has published properties ?>
			<?php
				foreach( $user_query_results as $agent_user ) {
					$agent = $agent_user->ID;
					$company_name = get_user_meta( $agent, 'company_name', true );
					$first_name = get_user_meta( $agent, 'first_name', true );
					$last_name = get_user_meta( $agent, 'last_name', true );
					$email = get_userdata( $agent );
					$email = $email->user_email;
					$office = get_user_meta( $agent, 'office_phone_number', true );
					$mobile = get_user_meta( $agent, 'mobile_phone_number', true );
					$fax = get_user_meta( $agent, 'fax_number', true );
					$website = get_userdata( $agent );
					$website = $website->user_url;
					$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
					$bio = get_user_meta( $agent, 'description', true );
					$profile_image = get_user_meta( $agent, 'user_image', true );
					$author_profile_url = get_author_posts_url( $agent );
					$facebook = get_user_meta( $agent, 'custom_facebook', true );
					$twitter = get_user_meta( $agent, 'custom_twitter', true );
					$google = get_user_meta( $agent, 'custom_google', true );
					$linkedin = get_user_meta( $agent, 'custom_linkedin', true );

					include get_template_directory() . '/lib/inc/template/agent-information.php';
				}
			?>
		<?php } else { ?>
			<p><?php esc_html_e( 'Publish at least one property to enable your public user profile.', 'realty' ); ?></p>
		<?php } ?>

		</div><!-- .col-sm-8 -->

		<?php if ( is_active_sidebar( 'sidebar_agent' ) ) { ?>
			<div class="col-sm-4 col-md-3">
				<ul id="sidebar">
					<?php dynamic_sidebar( 'sidebar_agent' ); ?>
				</ul>
			</div>
		<?php } ?>

	</div><!-- .row -->
</div>

<?php get_footer(); ?>