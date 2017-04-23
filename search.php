<?php
/**
 * template for displaying the search results
 */

get_header(); ?>

	<div class="site-container">
		<section class="content">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class(); ?> id="post-<?php echo get_the_ID(); ?>">
						<div class="entry-header">
							<p class="entry-date"><i class="fa fa-calendar"></i> <span class="post-date updated"><?php echo get_the_date(); ?></span></p>
							<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
						</div>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
							<p><a class="edd-submit button blue" href="<?php echo get_permalink(); ?>"><?php _e( 'Continue Reading...', 'edd' ); ?></a></p>
						</div>
						<div class="entry-footer">
							<?php eddwp_post_byline(); ?>
						</div>
					</article>

				<?php endwhile; ?>

				<?php
					global $wp_query;
					if ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>
						<div id="page-nav">
							<ul class="paged">
								<?php
									if ( get_next_posts_link() ) :
										?>
										<li class="previous">
											<?php next_posts_link( __( '<span class="nav-previous meta-nav">&larr; Older Posts</span>', 'edd' ) ); ?>
										</li>
										<?php
									endif;

									if ( get_previous_posts_link() ) :
										?>
										<li class="next">
											<?php previous_posts_link( __( '<span class="nav-next meta-nav">Newer Posts &rarr;</span>', 'edd' ) ); ?>
										</li>
										<?php
									endif;
								?>
							</ul>
						</div>
						<?php
					endif;
				?>

			<?php else : ?>

				<header class="page-header hentry">
					<h3 class="page-title">
						Oops! No search results for: <em><?php echo get_search_query(); ?></em>
					</h3>
					<p>Perhaps there is a typo in your search query. Feel free to try again.</p>
					<?php echo get_search_form(); ?>
				</header>

			<?php endif; // end if - have_posts() ?>

		</section>
		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>