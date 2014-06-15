<?php

/**
 * The template for displaying Themes.
 *
 * @package   EDD
 * @version   1.0
 * @since     1.0
 * @author	  Sunny Ratilal
 * @copyright Copyright (c) 2013, Sunny Ratilal.
 */
global $wp_query;
get_header();
?>
	<section class="main clearfix">
		<section class="content clearfix">
			<h1>Themes</h1>
			<p>These themes are built specifically to work with Easy Digital Downloads, helping you create beautiful stores in just minutes.</p>
		</section><!-- /.content -->

		<section class="themes-container">
			<div class="themes clearfix">
				<?php
				$c = 0; while ( have_posts() ) { the_post(); $c++;
				?>
					<div class="theme <?php if ( 0 == $c % 3 ) echo ' theme-clear'; ?>">
						<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
							<div class="thumbnail-holder"><?php the_post_thumbnail( 'theme-showcase' ); ?></div>
							<span class="theme-name"><?php the_title(); ?></span>
						</a>
					</div>
				<?php
				}
				?>
				<div class="clearfix">&nbsp;</div>
				<?php eddwp_paginate_links(); ?>
				<?php wp_reset_postdata(); ?>
			</div><!-- /.themes -->
		</section><!-- /.theme-container -->
	</section><!-- /.main -->
<?php get_footer(); ?>