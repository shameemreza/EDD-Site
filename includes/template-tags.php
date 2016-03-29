<?php
/**
 * custom template tags
 */


/* ----------------------------------------------------------- *
 * Comments
 * ----------------------------------------------------------- */

/**
 * Template for comments and pingbacks.
 */
function edd_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>

	<div <?php comment_class( 'clearfix' ); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php the_ID(); ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $args['avatar_size'] );?>
				<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
			</div><!-- /.comment-author -->

			<div class="comment-meta commentmetadata">
				<a class="comment-date" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() ); ?></a>
				<?php edit_comment_link( __( '(Edit)' ), '' ); ?>
			</div><!-- /.comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="alert"><?php echo apply_filters( 'eddwp_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'edd' ) ); ?></p>
			<?php endif; ?>

			<?php
				comment_text();
				comment_reply_link(
					array_merge(
						$args,
						array(
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'reply_text' => '<span class="comment-reply-link">Reply</span>',
						)
					)
				);
			?>
		</div>
	<?php
}


/**
 * custom comment form
 */
function eddwp_comment_form() {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="Name*" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" placeholder="Email*" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url">' . '<input id="url" placeholder="Website" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	comment_form(
		array(
			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_notes_after' => '<p class="comments-support-notice notice">If you need assistance, please open a <a href="https://easydigitaldownloads.com/support/">support ticket</a>.</p><p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		)
	);
}


/* ----------------------------------------------------------- *
 * Singulars
 * ----------------------------------------------------------- */

/**
 * Single post meta
 */
function eddwp_post_meta() {
	?>
	<div class="post-meta clearfix">
		<ul>
			<?php
				if ( is_single() ) :
					eddwp_author_box();
				endif;

				$categories = get_the_category_list( __( ', ', 'edd' ) );
				if ( $categories ) :
					?>
					<li><i class="fa fa-list-ul"></i> <?php echo $categories; ?></li>
					<?php
				endif;

				$tags = get_the_tag_list( '', __( ', ', 'edd' ) );
				if ( $tags ) :
					?>
					<li><i class="fa fa-tag"></i> <?php echo get_the_tag_list( '', __( ', ', 'edd' ) ); ?></li>
					<?php
				endif;

				// total number of comments including pings
				$response_count = get_comments_number();

				// total number of comments excluding pings
				$comment_count = eddwp_get_comments_only_count( $response_count );

				if ( comments_open() && ( 0 !== $comment_count ) && ! is_single() ) :
					if ( $comment_count >= 1 ) :
						$comment_total = $comment_count;
					endif;
					?>
					<li><i class="fa fa-comments-o"></i> <span class="the-comment-link"><?php comments_popup_link( __( 'Leave a comment', 'edd' ), __( '1 Comment', 'edd' ), $comment_total . ' ' . __( 'Comments', 'edd' ), '', ''); ?></span></li>
					<?php
				endif;
			?>
		</ul>
	</div><!-- /.post-meta-->
	<?php
}


/**
 * Single post author box
 */
function eddwp_author_box() {
	$author_url = get_the_author_meta( 'user_url' );
	?>
		<div class="edd-author-box clearfix">
			<div class="edd-author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 85, '', get_the_author_meta( 'display_name' ) ); ?>
			</div>
			<div class="edd-author-bio">
				<h4 class="edd-author-title">Written by <?php echo get_the_author_meta( 'display_name' ); ?></h4>
				<?php if ( $author_url ) { ?>
					<span class="edd-author-url"><a href="<?php echo esc_url( $author_url ); ?>" target="_blank"><i class="fa fa-link"></i></a></span>
				<?php } ?>
				<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>
			</div>
		</div>
	<?php
}


/* ----------------------------------------------------------- *
 * Product Display
 * ----------------------------------------------------------- */

/**
 * Featured image for downloads grid output
 */
function eddwp_downloads_grid_thumbnail() {
	global $post;

	// replace old featured image programmatically until fully removed
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
	$old_default = home_url( '/wp-content/uploads/2013/07/defaultpng.png' );

	if( has_post_thumbnail() && $image[0] !== $old_default ) {
		the_post_thumbnail( 'download-grid-thumb', array( 'class' => 'download-grid-thumb' ) );
	} else {
		echo '<img class="download-grid-thumb wp-post-image" src="' . get_template_directory_uri() . '/images/featured-image-default.png" alt="' . get_the_title() . '" />';
	}
}


/**
 * product pagination
 */
function eddwp_paginate_links() {
	global $wp_query;

	$big = 999999999;

	if ( ! function_exists( 'edd_get_current_page_url' ) ) {
		return;
	}

	$url = edd_get_current_page_url();

	if ( false === strpos( $url, '?' ) ) {
		$sep = '?';
	} else {
		$sep = '&';
	}

	echo '<div class="pagination clearfix">' . paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format' => $sep . 'paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $wp_query->max_num_pages,
	) ) . '</div>';
}


/* ----------------------------------------------------------- *
 * Misc
 * ----------------------------------------------------------- */

/**
 * Universal Newsletter Sign Up Form
 */
function eddwp_newsletter_form() {
	?>
	<div class="newsletter">
		<h3 class="newsletter-title"><span>Subscribe to the Easy Digital Downloads </span>Email Newsletter</h3>
		<div class="edd-newsletter-content-wrap">
			<p class="newsletter-description">Be the first to know about the latest updates and exclusive promotions from Easy Digital Downloads by submitting your information below.</p>
			<form class="newsletter-form" id="pmc_mailchimp" action="" method="post">
				<div class="newsletter-name-container">
					<input class="newsletter-name" name="pmc_fname" id="pmc_fname" type="text" placeholder="First Name"/>
				</div>
				<div class="newsletter-email-container">
					<input class="newsletter-email" name="pmc_email" id="pmc_email" type="text" placeholder="Email Address"/>
				</div>
				<div class="newsletter-submit-container">
					<input type="hidden" name="redirect" value="<?php if ( function_exists( 'edd_get_current_page_url' ) ) { echo edd_get_current_page_url(); } ?>"/>
					<input type="hidden" name="action" value="pmc_signup"/>
					<input type="hidden" name="pmc_list_id" value="be2b495923"/>
					<input type="submit" class="newsletter-submit edd-submit button darkblue" value="Sign Up"/>
				</div>
			</form>
			<p class="newsletter-note"><i class="fa fa-lock"></i>We will never send you spam. Your email address is secure.</p>
		</div>
	</div>
	<?php
}


/**
 * Google Custom Search
 */
function eddwp_google_custom_search() {
	?>
	<script>
	  (function() {
		var cx = '013364375160530833496:u0gpdnp1z-8';
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//www.google.com/cse/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(gcse, s);
	  })();
	</script>
	<gcse:search></gcse:search>
	<?php
}


/**
 * query upcoming commissions
 */
function eddc_get_upcoming_commissions(){
	global $user_ID;

	if( ! is_user_logged_in() ) {
		return;
	}

	$day    = date( 'd', strtotime( 'today' ));
	$month  = date( 'm', strtotime( 'today' ));
	$year   = date( 'Y', strtotime( 'today' ));
	$from   = '';
	$to     = '';
	if ( $day > 15 ){
		if ( $month == 1 ){
			$year_last = $year - 1;
			$from      = '12/15/'.$year_last;
			$to        = '01/15/'.$year;
		} else {
			$last_month = $month - 1;
			$from       = $last_month.'/15/'.$year;
			$to         =   $month.'/15/'.$year;
		}

	} else {

		if ( $month == 2 ){
			$year_last = $year - 1;
			$from      = '12/15/'.$year_last;
			$to        = '01/15/'.$year;
		} else if ( $month == 1 ){
			$year_last = $year - 1;
			$from      = '11/15/'.$year_last;
			$to        = '12/15/'.$year_last;
		} else {
			$last_month = $month - 1;
			$two_months = $month - 2;
			$from       = $two_months.'/15/'.$year;
			$to         = $last_month.'/15/'.$year;
		}
	}
	$from = explode( '/', $from );
	$to   = explode( '/', $to );

	$query = array(
		'post_type'      => 'edd_commission',
		'nopaging'		 => true,
		'date_query' => array(
			'after'       => array(
				'year'    => $from[2],
				'month'   => $from[0],
				'day'     => $from[1],
			),
			'before'      => array(
				'year'    => $to[2],
				'month'   => $to[0],
				'day'     => $to[1],
			),
			'inclusive' => true
		),
		'meta_key' => '_user_id',
		'meta_value' => $user_ID,
		'tax_query'      => array(
			array(
				'taxonomy' => 'edd_commission_status',
				'terms'    => 'unpaid',
				'field'    => 'slug'
			)
		),
		'fields'        => 'ids'
	);
	$commissions = new WP_Query( $query );
	$total = (float) 0;
	if ( $commissions->have_posts() ) {
		foreach ( $commissions->posts as $id ) {
			$commission_info = get_post_meta( $id, '_edd_commission_info', true );
			$total += $commission_info['amount'];
		}
	}

	$total = edd_sanitize_amount( $total );
	$from = implode( '/', $from );
	$to   = implode( '/', $to );

	return 'Next payout for Commissions earned from '.  date( 'm/d/Y', strtotime( $from ) ) .' to '. date( 'm/d/Y', strtotime( $to ) ) . ' will be: <strong>' . edd_currency_filter( edd_format_amount( $total ) ) . '</strong>';
}


/**
 * This function is used in the footer template to get the latest blog post.
 */
function eddwp_get_latest_post( $count = 3 ) {
	$items = get_posts( array( 'posts_per_page' => $count ) );
	?>
	<h4>Latest Blog Posts</h4>
	<ul>
		<?php
			foreach ( $items as $item ) :
				printf( '<li class="latest-posts"><a href="%1$s">%2$s</a></li>',
					get_permalink( $item->ID ),
					$item->post_title
				);
			endforeach;
		?>
	</ul>
	<?php
}


/**
 * Output EDD social networking profile icons
 */
function eddwp_social_networking_profiles( $args = array() ) {
	echo $args['wrap'] ? '<div class="edd-social-profiles">' : '';
	$square = $args['square'] ? '-square' : '';
		?>
			<?php if ( $args['title'] ) : ?>
				<span class="edd-social-profiles-title">
					<?php echo $args['title']; ?>
				</span>
			<?php endif; ?>
			<a class="social-icon" href="https://www.facebook.com/eddwp">
				<i class="fa fa-facebook<?php echo $square; ?>"></i>
			</a>
			<a class="social-icon" href="https://twitter.com/eddwp">
				<i class="fa fa-twitter<?php echo $square; ?>"></i>
			</a>
			<a class="social-icon" href="https://plus.google.com/111409933861760783237/posts">
				<i class="fa fa-google-plus<?php echo $square; ?>"></i>
			</a>
			<a class="social-icon" href="https://github.com/easydigitaldownloads/Easy-Digital-Downloads/">
				<i class="fa fa-github<?php echo $square; ?>"></i>
			</a>
		<?php
	echo $args['wrap'] ? '</div>' : '';
}

/**
 * Get the total number of non-third party extensions
 */
function eddwp_get_number_of_downloads() {
 	$total = get_transient( 'eddwp_get_number_of_downloads' );
	if ( empty( $number ) ) {
		$download_count = wp_count_posts( 'download' )->publish;
		$exclude        = 0;

		$bundles    = get_term( 1524, 'download_category' ); // Bundles
		if ( ! empty( $bundles ) && ! is_wp_error( $bundles ) ) {
			$exclude += $bundles->count;	
		}
		
		$thirdparty = get_term( 1536, 'download_category' ); // Third Party
		if ( ! empty( $thirdparty ) && ! is_wp_error( $thirdparty ) ) {
			$exclude += $thirdparty->count;	
		}
		
		$total = $download_count - $exclude;
		set_transient( 'eddwp_get_number_of_downloads', $total, 60 * 60 * 24 );
	}
	return $total;
}
