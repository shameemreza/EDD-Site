<?php
/**
 * The template for displaying an extension.
 *
 * @package   EDD
 * @version   1.0
 * @since     1.0
 * @author	  Sunny Ratilal
 * @copyright Copyright (c) 2013, Sunny Ratilal.
 */

global $post;

get_header();
the_post();
?>

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<h1><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</section><!-- /.content -->

			<aside class="sidebar">
				<div class="box">
					<h3>Extension Details</h3>
					<div class="author clearfix">
						<p><span class="extension-detail-label">Developer:</span>&nbsp;
							<?php if( get_post_meta( get_the_ID(), 'ecpt_hideauthorlink', true ) ) : ?>
								<span class="extension-detail"><?php echo get_post_meta( get_the_ID(), 'ecpt_developer', true ); ?></span>
							<?php else : ?>
								<span class="extension-detail"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a></span>
							<?php endif; ?>
						</p>
					</div>
					<?php if( ! has_term( 'bundles', 'extension_category', get_the_ID() ) ) { ?>
					<div class="version clearfix">
						<?php
							$download_id = get_post_meta( get_the_ID(), 'ecpt_downloadid', true );
							$version = get_post_meta( $download_id, '_edd_sl_version', true );
						?>
						<p><span class="extension-detail-label">Version:</span> <span class="extension-detail"><?php echo $version; ?></span></p>
					</div>
					<?php } // end if  ?>
					<?php if ( ! eddwp_is_extension_third_party() && ! eddwp_is_external_extension() ) { ?>
					<div class="pricing">
						<h3>Pricing</h3>
						<?php echo edd_get_purchase_link( array( 'download_id' => get_post_meta( get_the_ID(), 'ecpt_downloadid', true ) ) ); ?>
					</div>
					<div class="terms clearfix">
						<p>Extensions subject to yearly license for support and updates. <a href="https://easydigitaldownloads.com/docs/extensions-terms-conditions/" target="_blank">View license terms</a>.</p>
					</div>
					<?php } // end if ?>
					<?php if( eddwp_is_external_extension() ) { ?>
						<a href="<?php echo esc_url( eddwp_get_external_extension_url() ); ?>" title="View Extension Details" class="edd-submit button blue">View Extension</a>
					<?php } ?>
					<?php
						if ( function_exists('p2p_register_connection_type') ) :
		
							$external_doc = get_post_meta( get_the_ID(), 'ecpt_documentationlink', true );

							// Find connected posts
							$docs = new WP_Query( array(
							  'connected_type' => 'extensions_to_docs',
							  'connected_items' => get_queried_object(),
							  'nopaging' => true,
							  'post_status' => 'publish'
							) );
		
							// Find connected forums
							$forums = new WP_Query( array(
							  'connected_type' => 'extensions_to_forums',
							  'connected_items' => get_queried_object(),
							  'nopaging' => true,
							  'post_status' => 'publish'
							) );
		
							if ( $forums->have_posts() || $docs->have_posts() ) {
								echo '<div class="related-items">';
									// Display connected posts
									if ( $external_doc || $docs->have_posts() ) :
										echo '<h3>Documenation</h3>';
										echo '<ul class="related-links">';
										if( empty( $external_doc ) ) :
											while ( $docs->have_posts() ) : $docs->the_post(); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
												<?php
											endwhile;
										else :
											echo '<li><a href="' . esc_url( $external_doc ) . '">View Setup Documentation</a></li>';
										endif;
										echo '</ul>';
										wp_reset_postdata();
									endif;							
									// Display connected posts
									if ( $forums->have_posts() ) :				
										echo '<h3>Support</h3>';
										while ( $forums->have_posts() ) : $forums->the_post(); ?>
											<div>Need help? Visit the <a href="<?php the_permalink(); ?>">Support Forums</a>.</div>
											<?php
										endwhile;
										wp_reset_postdata();
									endif;
								echo '</div>';
							}
						endif;
					?>
				</div>
			</aside><!-- /.sidebar -->
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>