<?php
/**
 * AJAX - Favorites
 *
 */
if ( ! function_exists( 'tt_ajax_add_remove_favorites' ) ) {
	function tt_ajax_add_remove_favorites() {

		$user_id = $_GET['user'];
		$property_id = $_GET['property'];

		// Get Favorites Meta Data
		$get_user_meta_favorites = get_user_meta( $user_id, 'realty_user_favorites', false ); // false = array()

		if ( ! $get_user_meta_favorites ) {
			// No User Meta Data Favorites Found -> Add Data
			$create_favorites = array($property_id);
			add_user_meta( $user_id, 'realty_user_favorites', $create_favorites );
		} else {
			// Meta Data Found -> Update Data
			if ( ! in_array( $property_id, $get_user_meta_favorites[0] ) ) {
				// Add New Favorite
				array_unshift( $get_user_meta_favorites[0], $property_id ); // Add To Beginning Of Favorites Array
				update_user_meta( $user_id, 'realty_user_favorites', $get_user_meta_favorites[0] );
			} else {
				// Remove Favorite
				$removeFavoriteFromPosition = array_search( $property_id, $get_user_meta_favorites[0] );
				unset($get_user_meta_favorites[0][$removeFavoriteFromPosition]);
				update_user_meta( $user_id, 'realty_user_favorites', $get_user_meta_favorites[0] );
			}
		}

	}
}
add_action( 'wp_ajax_tt_ajax_add_remove_favorites', 'tt_ajax_add_remove_favorites' );

/**
 * Favorites - Click
 *
 */
if ( !function_exists('tt_add_remove_favorites') ) {
	function tt_add_remove_favorites( $property_id = 0 ) {

		global $realty_theme_option;

		if ( $realty_theme_option['property-favorites-disabled'] ) {
			return;
		}

		$add_favorites_temporary = $realty_theme_option['property-favorites-temporary'];

		if ( ! $property_id ) {
			$property_id = get_the_ID();
		}

		if ( is_user_logged_in() ) {
			// Logged-In User
			$user_id = get_current_user_id();
			$get_user_meta_favorites = get_user_meta( $user_id, 'realty_user_favorites', false ); // false = array()

			if ( ! empty( $get_user_meta_favorites ) && in_array( $property_id, $get_user_meta_favorites[0] ) ) {
				// Property Is Already In Favorites
				$favicon = '<i class="add-to-favorites icon-heart" data-fav-id="' . $property_id . '" data-toggle="tooltip" title="' . esc_html__( 'Bỏ thích', 'realty' ) . '"></i>';
			} else {
				// Property Isn't In Favorites
				$favicon = '<i class="add-to-favorites icon-heart-1" data-fav-id="' . $property_id . '" data-toggle="tooltip" title="' . esc_html__( 'Thích', 'realty' ) . '"></i>';
			}
		} else {
			// Not Logged-In Visitor
			$favicon = '<i class="add-to-favorites icon-heart-1" data-fav-id="' . $property_id . '" data-toggle="tooltip" title="' . esc_html__( 'Thích', 'realty' ) . '"></i>';
		}

		return $favicon;

	}
}

/**
 * Favorites - Script
 *
 */
if ( ! function_exists( 'tt_favorites_script' ) ) {
	function tt_favorites_script() {

		global $realty_theme_option;
		$add_favorites_temporary = $realty_theme_option['property-favorites-temporary'];
		?>

		<script>
		<?php
		// Temporary Favorites
		if ( ! is_user_logged_in() && $realty_theme_option['property-favorites-temporary'] ) {
		?>
		jQuery('.add-to-favorites').each(function() {

			// Check If item Already In Favorites Array
			function inArray(needle, haystack) {
		    if ( haystack ) {
			    var length = haystack.length;
			    for( var i = 0; i < length; i++ ) {
			      if(haystack[i] == needle) return true;
			    }
			    return false;
		    }
			}

			// Check If Browser Supports LocalStorage
			if (!store.enabled) {
		    alert('<?php echo __( 'Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.', 'realty' ); ?>');
				return;
		  }
			// Toggle Heart Class
			if ( inArray( jQuery(this).attr('data-fav-id'), store.get('favorites') ) ) {

				jQuery(this).toggleClass('icon-heart icon-heart-1');

				if ( jQuery(this).hasClass('icon-heart') ) {
					jQuery(this).attr('data-original-title', '<?php esc_html_e( 'Bỏ thích', 'realty' ); ?>');
				}

			}

		});
		<?php } ?>

		jQuery('.container').on("click",'.add-to-favorites',function() {

			<?php
			// Logged-In User Or Temporary Favorites Enabled
			if ( is_user_logged_in() || $add_favorites_temporary ) {
			?>

				// Toggle Favorites Tooltips
				if ( jQuery(this).hasClass('icon-heart') ) {
					jQuery(this).attr('data-original-title', '<?php esc_html_e( 'Bỏ thích', 'realty' ); ?>');
				}

				jQuery(this).find('i').toggleClass('icon-heart icon-heart-1');
				jQuery(this).closest('i').toggleClass('icon-heart icon-heart-1');

				<?php if ( is_user_logged_in() ) { ?>
					<?php $user_id = get_current_user_id();	?>
					jQuery.ajax({
					  type: 'GET',
					  url: ajax_object.ajax_url,
					  data: {
					    'action'        :   'tt_ajax_add_remove_favorites', // WP Function
					    'user'					: 	<?php echo $user_id; ?>,
					    'property'			: 	jQuery(this).attr('data-fav-id')
					  },
					  success: function (response) { },
					  error: function () { }
					});

					<?php } else if ( $add_favorites_temporary ) { ?>

					if (!store.enabled) {
				    alert('<?php echo __( 'Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.', 'realty' ); ?>');
						return;
				  }

					// Check For Temporary Favorites (store.js plugin)
					if ( store.get('favorites') ) {

						// Check If item Already In Favorites Array
						function inArray(needle, haystack) {
					    var length = haystack.length;
					    for( var i = 0; i < length; i++ ) {
				        if(haystack[i] == needle) return true;
					    }
					    return false;
						}

						var getFavs = store.get('favorites');
						var newFav = jQuery(this).attr('data-fav-id');

						if ( inArray( newFav, getFavs ) ) {
							// Remove Old Favorite
							var index = getFavs.indexOf(newFav);
							getFavs.splice(index, 1);
						} else {
							// Add New Favorite
							getFavs.push( newFav );
						}
						store.set( 'favorites', getFavs );

					} else {

						var arrayFav = [];
						arrayFav.push( jQuery(this).attr('data-fav-id') );
						store.set( 'favorites', arrayFav );

					}

					console.log( store.get('favorites') );

				<?php } ?>

			<?php } else { // Not Logged-In Visitor - Show Modal ?>
				jQuery('#msg-login-to-add-favorites').removeClass('hide');
				jQuery('a[href="#tab-login"]').tab('show');
				jQuery('#login-modal').modal();
				jQuery('#login-modal').on('hidden.bs.modal', function () {
					jQuery('#msg-login-to-add-favorites').addClass('hide');
				});
			<?php } ?>

		});
		</script>

	<?php
	}
}
add_action( 'wp_footer', 'tt_favorites_script', 21 );

/**
 * Favorites Temporary
 *
 */
if ( ! function_exists( 'tt_ajax_favorites_temporary' ) ) {
	function tt_ajax_favorites_temporary() {

		$favorites_temporary_args['post_type'] = 'property';
		$favorites_temporary_args['post_status'] = 'publish';
		$favorites_temporary_args['paged'] = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		global $realty_theme_option;
		$search_results_per_page = $realty_theme_option['search-results-per-page'];

		// Search Results Per Page: Check for Theme Option
		if ( $search_results_per_page ) {
			$favorites_temporary_args['posts_per_page'] = $search_results_per_page;
		} else {
			$favorites_temporary_args['posts_per_page'] = 10;
		}

		if ( isset( $_GET['favorites'] ) ) {
			$favorites_temporary_args['post__in'] = $_GET['favorites'];
		} else {
			$favorites_temporary_args['post__in'] = array( '0' );
		}

		$query_favorites_temporary = new WP_Query( $favorites_temporary_args );
		?>

		<?php if ( $query_favorites_temporary->have_posts() ) : ?>
			<div class="property-items">
				<ul class="row list-unstyled">
					<?php
						$count_results = $query_favorites_temporary->found_posts;
						while ( $query_favorites_temporary->have_posts() ) : $query_favorites_temporary->the_post();
						global $realty_theme_option;
						$columns = $realty_theme_option['property-listing-columns'];
						if ( empty($columns) ) {
							$columns = "col-md-6";
						}
					?>
						<li class="<?php echo $columns; ?>">
							<?php get_template_part( 'lib/inc/template/property', 'item' );	?>
						</li>
					<?php endwhile; ?>
					<?php wp_reset_query(); ?>
				</ul>
			</div>

		<?php endif; ?>

		<?php
		die();

	}
}
add_action('wp_ajax_tt_ajax_favorites_temporary', 'tt_ajax_favorites_temporary');
add_action('wp_ajax_nopriv_tt_ajax_favorites_temporary', 'tt_ajax_favorites_temporary');