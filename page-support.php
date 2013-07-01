<?php
/**
 * The template for displaying the bbPress forums index.
 *
 * @package EDD
 */

get_header(); ?>

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<?php while ( have_posts() ) { the_post(); ?>
				<article class="entry">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</article>
				<?php } ?>
			</section><!-- /.content -->
			<?php get_sidebar( 'forums' ); ?>
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>