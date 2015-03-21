<?php
/**
 * The template for displaying the blog index page.
 *
 * @package   EDD
 * @version   1.0
 * @since     1.0
 * @author	  Sunny Ratilal
 * @copyright Copyright (c) 2013, Sunny Ratilal.
 */
?>
<?php get_header(); ?>

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<?php while ( have_posts() ) { the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php echo get_the_ID(); ?>">
					<p class="entry-date"><span><?php the_date(); ?></span></p>
					<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
					<p><a href="<?php echo get_permalink(); ?>"><?php _e( 'Continue Reading...', 'edd' ); ?></a></p>
					<div class="post-meta">
						<ul>
							<li><i class="fa fa-user"></i> <?php the_author(); ?></li>
							<?php
							$categories = get_the_category_list( __( ', ', 'edd' ) );

							if ( $categories ) {
							?>
							<li><i class="fa fa-list-ul"></i> <?php echo $categories; ?></li>
							<?php
							} // end if

							$tags = get_the_tag_list( '', __( ', ', 'edd' ) );
							if ( $tags ) {
							?>
							<li><i class="fa fa-tag"></i> <?php echo get_the_tag_list( '', __( ', ', 'edd' ) ); ?></li>
							<?php } ?>
							<?php if ( comments_open() ) { ?>
							<li><i class="fa fa-comments-o"></i> <span class="the-comment-link"><?php comments_popup_link( __( 'Leave a comment', 'edd' ), __( '1 Comment', 'edd' ), __( '% Comments', 'edd' ), '', ''); ?></span></li>
							<?php } // end if ?>
						</ul>
					</div><!-- /.post-meta-->
				</article><!-- /#post-<?php echo get_the_ID(); ?> -->
				<?php } ?>

				<?php
				global $wp_query;
				if ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) { ?>
					<div id="page-nav">
						<ul class="paged">
							<?php if( get_next_posts_link() ) { ?>
								<li class="previous">
									<?php next_posts_link( __( '<span class="nav-previous meta-nav"><i class="fa fa-chevron-left"></i> Older</span>', 'edd' ) ); ?>
								</li>
							<?php
							} if( get_previous_posts_link() ) { ?>
								<li class="next">
									<?php previous_posts_link( __( '<span class="nav-next meta-nav">Newer <i class="fa fa-chevron-right"></i></span>', 'edd' ) ); ?>
								</li>
							<?php } ?>
						</ul><!-- /.paged -->
					</div><!-- /#page-nav -->
				<?php } ?>
			</section><!-- /.content -->

			<aside class="sidebar">
				<div class="newsletter widget">
					<h3 class="newsletter-title">Email Newsletter</h3>
					<p class="newsletter-description">Sign up to the Easy Digital Downloads email newsletter and be the first to know about the latest information and exclusive promotions.</p>
					<form class="newsletter-form" id="pmc_mailchimp" action="" method="post">
						<div>
							<input class="newsletter-name" name="pmc_fname" id="pmc_fname" type="text" placeholder="First Name"/>
						</div>
						<div>
							<input class="newsletter-email" name="pmc_email" id="pmc_email" type="text" placeholder="Email Address"/>
						</div>
						<div>
							<input type="hidden" name="redirect" value="<?php echo 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?>"/>
							<input type="hidden" name="action" value="pmc_signup"/>
							<input type="hidden" name="pmc_list_id" value="<?php echo $list_id; ?>"/>
							<input type="submit" value="Sign Up"/>
						</div>
					</form>
					<p class="newsletter-note"><i class="fa fa-lock"></i>We will never send you spam. Your email address is secure.</p>
				</div>
				<?php dynamic_sidebar( 'blog-sidebar' ); ?>
			</aside><!-- /.sidebar -->
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>