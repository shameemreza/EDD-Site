<?php
/**
 * Template Name: Themes Page
 *
 * The template for displaying all the themes.
 */

get_header();
the_post();
$featured_theme_args = array(
	'post_type' => 'download',
	'orderby'   => 'menu_order',
	'order'     => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'download_category',
			'field'    => 'slug',
			'terms'    => 'featured-theme',
		),
	),
);
$featured_theme = new WP_Query( $featured_theme_args );
$no_duplicates = array(); // don't repeat the same theme twice
?>

	<?php while ( $featured_theme->have_posts() ) : $featured_theme->the_post(); $no_duplicates[] = $post->ID; ?>
		<div class="featured-download-area page-section-blue full-width">
			<div class="inner">
				<div class="featured-download clearfix">
					<div class="featured-download-info">
						<span class="featured-download-label">Featured Theme</span>
						<?php
						the_title( '<h1 class="featured-download-title">', '</h1>' );
						the_excerpt();

						echo edd_get_purchase_link( array( 'id' => get_the_ID() ) );
						?>
						or <a class="featured-download-secondary-link" href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">see <?php the_title(); ?> details</a>
					</div>
					<div class="featured-download-thumb">
						<a href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">
							<?php
							if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'featured-download', array( 'class' => 'featured-download-img' ) );
							endif;
							?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; wp_reset_postdata(); ?>

	<div class="edd-downloads-area official-themes-area page-section-white full-width">
		<div class="inner">
			<div class="edd-downloads">
				<div class="section-header">
					<h2 class="section-title">Official Easy Digital Downloads Themes</h2>
					<p class="section-subtitle">These themes were optimized to work with EDD and its extensions by our team members.</p>
				</div>
				<section class="download-grid two-col clearfix">
					<?php
						$eddwp_theme_args = array(
							'post_type' => 'download',
							'orderby'   => 'menu_order',
							'order'     => 'ASC',
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => 'download_category',
									'field'    => 'slug',
									'terms'    => 'themes',
								),
								array(
									'taxonomy' => 'download_category',
									'field'    => 'slug',
									'terms'    => '3rd-party',
									'operator' => 'NOT IN',
								),
							),
						);
						$eddwp_themes = new WP_Query( $eddwp_theme_args );

						while ( $eddwp_themes->have_posts() ) : $eddwp_themes->the_post();
							if ( ! in_array( $post->ID, $no_duplicates ) ) :
								?>
								<div class="download-grid-item">
									<div class="download-grid-thumb-wrap">
										<a href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">
											<?php eddwp_downloads_grid_thumbnail(); ?>
										</a>
									</div>
									<div class="download-grid-item-info">
										<?php
											the_title( sprintf(
												'<h4 class="download-grid-title"><a href="%s">',
												home_url( '/downloads/' . $post->post_name ) ),
												'</a></h4>'
											);
											$short_desc = get_post_meta( get_the_ID(), 'ecpt_shortdescription', true );
											echo $short_desc;
										?>
									</div>
									<div class="download-grid-item-cta">
										<a class="download-grid-item-primary-link button" href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">More Information</a>
									</div>
								</div>
								<?php
							endif;
						endwhile;
						wp_reset_postdata();
					?>
					<div class="download-grid-item flex-grid-cheat"></div>
				</section><!-- .download-grid two-col -->
			</div>
		</div>
	</div>

	<div class="recommended-downloads-area page-section-gray full-width">
		<div class="inner">
			<div class="recommended-downloads">
				<div class="section-header">
					<h2 class="section-title">Recommended Community Themes</h2>
					<p class="section-subtitle">The following themes were designed by talented developers from the EDD community.</p>
				</div>
				<section class="download-grid three-col clearfix">
					<?php
						$eddwp_theme_args = array(
							'post_type' => 'download',
							'orderby'   => 'menu_order',
							'order'     => 'ASC',
							'posts_per_page' => 100,
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => 'download_category',
									'field'    => 'slug',
									'terms'    => 'themes',
								),
								array(
									'taxonomy' => 'download_category',
									'field'    => 'slug',
									'terms'    => '3rd-party',
								),
							),
						);
						$eddwp_themes = new WP_Query( $eddwp_theme_args );

						while ( $eddwp_themes->have_posts() ) : $eddwp_themes->the_post();
							?>
							<div class="download-grid-item">
								<div class="download-grid-thumb-wrap">
									<a href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">
										<?php eddwp_downloads_grid_thumbnail(); ?>
									</a>
								</div>
								<div class="download-grid-item-info">
									<?php
										the_title( sprintf(
											'<h4 class="download-grid-title"><a href="%s">',
											home_url( '/downloads/' . $post->post_name ) ),
											'</a></h4>'
										);
										$short_desc = get_post_meta( get_the_ID(), 'ecpt_shortdescription', true );
										echo $short_desc;
									?>
								</div>
								<div class="download-grid-item-cta">
									<a class="download-grid-item-primary-link button" href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">More Information</a>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
					?>
					<div class="download-grid-item flex-grid-cheat"></div>
					<div class="download-grid-item flex-grid-cheat"></div>
				</section><!-- .download-grid three-col -->
				<div class="third-party-themes-section">
					<p>View more themes built by talented developers from the ThemeForest community.</p>
					<a class="edd-submit button blue" href="http://themeforest.net/tags/easy%20digital%20downloads?ref=mordauk"><i class="fa fa-paint-brush"></i> EDD Themes on ThemeForest</a>
				</div>
			</div>
		</div>
	</div>
	<?php

get_footer();