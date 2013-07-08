<?php
/**
 * The template for displaying the blog index page.
 *
 * @package EDD
 */

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
				<div class="newsletter">
					<h3>Email Newsletter</h3>
					<p>Sign up to receive regular updates from Easy Digital Downloads.</p>
					<form id="pmc_mailchimp" action="" method="post">
						<div>
							<input name="pmc_fname" id="pmc_fname" type="text" placeholder="<?php _e('Name'); ?>"/>
						</div>
						<div>
							<input name="pmc_email" id="pmc_email" type="text" placeholder="<?php _e('Enter your email address'); ?>"/>
						</div>
						<div>
							<input type="hidden" name="redirect" value="<?php echo 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?>"/>
							<input type="hidden" name="action" value="pmc_signup"/>
							<input type="hidden" name="pmc_list_id" value="<?php echo $list_id; ?>"/>
							<input type="submit" value="<?php _e( 'Sign Up' ); ?>"/>
						</div>
					</form>
				</div>
				<?php dynamic_sidebar( 'blog-sidebar' ); ?>
			</aside><!-- /.sidebar -->
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>