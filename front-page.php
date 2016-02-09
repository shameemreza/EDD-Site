<?php
/**
 * The template for displaying the front page.
 *
 * @package EDD
 * @version 1.0
 * @since   1.0
 */

get_header(); ?>

<div id="front-page-hero" class="front-page-section page-section-blue full-width">
	<div class="inner">
		<div class="front-page-intro">
			<div class="site-headline">
				<span class="hero-subtitle">Say hello to the world's easiest way to</span>
				<h1 class="hero-title">Sell Digital Downloads Through WordPress</h1>
			</div>
			<p class="hero-cta">
				<a class="hero-primary-cta-button" href="http://downloads.wordpress.org/plugin/easy-digital-downloads.latest-stable.zip?utm_source=home&utm_medium=button_2&utm_campaign=Download+Button"><i class="fa fa-cloud-download"></i>Download</a><br>
				or <a class="hero-secondary-cta-link" href="https://easydigitaldownloads.com/demo/">view the demo</a>
			</p>
		</div>
	</div>
</div>

<div id="front-page-about-edd" class="features-grid-three page-section-white full-width">
	<div class="inner">
		<div class="features-grid-three-content page-section">
			<div class="page-section-header">
				<h2 class="page-section-title"><strong>Things to Know</strong> About Easy Digital Downloads</h2>
				<p>Easy Digital Downloads is built to be quick and simple to set up. After installation, you're ready to go in just a couple of minutes! Simply enter your payment information and add your products. The rest is all a dream.</p>
			</div>
			<div class="features-grid-content-sections">
				<div class="edd-feature">
					<img class="edd-feature-image" src="<?php echo get_template_directory_uri() ?>/images/best-reporting.png" alt="Reporting" />
					<h6>Elegant Reporting</h6>
					<p>You want to be able to see all of your sales and earnings presented neatly and in a way that is easy to analyse. We have done exactly that with beautiful graphs and simple data tables.</p>
				</div>
				<div class="edd-feature">
					<img class="edd-feature-image" src="<?php echo get_template_directory_uri() ?>/images/welcome-developers.png" alt="Developer Friendly" />
					<h6>Developer Friendly</h6>
					<p>Not only does Easy Digital Downloads closely follow the WordPress Coding Standards and provide a myriad of hooks and filters for developers, it's also 100% open-source and welcomes contributors.</p>
				</div>
				<div class="edd-feature">
					<img class="edd-feature-image" src="<?php echo get_template_directory_uri() ?>/images/create-discounts.png" alt="Discount Codes" />
					<h6>Discount Codes</h6>
					<p>Celebrating something? Or maybe you just woke up in a good mood! Whatever it is, we have a complete discount system built in, so when you want to provide an offer, it won't even take a minute.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="front-page-data-export" class="front-page-section page-section-white full-width">
	<div class="inner">
		<div class="front-page-data-export-content half-split image-left clearfix">
			<div class="split-text">
				<h2 class="front-page-section-title">Easily <strong>Export Store Data</strong></h2>
				<p>Easy Digital Downloads will never lock your data in. With our simple export options, you can easily send all sales, earnings, and customer data to Excel, Google Docs, or any other reporting system of your choice.</p>
				<p>You also have the freedom to be as specific as you need when exporting your data. Choose a custom start date as well as a custom end date to get just the necessary data for your reporting.</p>
				<p><a class="edd-submit button blue" href="<?php echo home_url( '/edd-features/' ); ?>"><i class="fa fa-eye"></i>See All Features</a></p>
			</div>
			<div class="split-image">
				<img class="primary-export-image" style="border-right: 1px solid #f1f1f1;" src="<?php echo get_template_directory_uri() ?>/images/export-store-data.png" alt="Data Export" />
				<img class="secondary-export-image" src="<?php echo get_template_directory_uri() ?>/images/export-store-data-full.png" alt="Data Export" />
			</div>
		</div>
	</div>
</div>

<div id="front-page-integrations" class="front-page-section page-section-white full-width">
	<div class="inner">
		<div class="front-page-integrations page-section">
			<h5 class="integrations-description">Extend Easy Digital Downloads With Your Favorite Services</h5>
			<img src="<?php echo get_template_directory_uri() ?>/images/edd-integrations.png" alt="Easy Digital Downloads Integrations" />
		</div>
	</div>
</div>

<div id="front-page-extensions" class="front-page-section page-section-gray full-width">
	<div class="inner">
		<div class="front-page-extensions-header page-section">
			<div class="page-section-header">
				<h2 class="page-section-title">Easy Digital Downloads <strong>Tailored to Your Business</strong></h2>
				<p>With over 190 extensions, Easy Digital Downloads can be customized to function the way you need. From payment processors to newsletter signup forms, EDD has extensions to fill the needs of almost every user.</p>
			</div>
		</div>
		<div class="front-page-extensions-content edd-downloads">
			<div class="download-grid three-col clearfix">
				<?php
				$extensions = new WP_Query(
					array(
						'post_type'      => 'download',
						'posts_per_page' => 6,
						'post_status'    => 'publish',
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'tax_query'      => array(
							'relation'   => 'AND',
							array(
								'taxonomy' => 'download_category',
								'field'    => 'slug',
								'terms'    => 'extensions'
							),
							array(
								'taxonomy' => 'download_tag',
								'field'    => 'slug',
								'terms'    => 'featured'
							)
						)
					)
				);

				while ( $extensions->have_posts() ) : $extensions->the_post();
					?>
					<div class="download-grid-item">
						<a href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">
							<?php eddwp_downloads_grid_thumbnail(); ?>
						</a>
						<div class="download-grid-item-info">
							<?php
								the_title( '<h4 class="download-grid-title"><a href="' . home_url( '/downloads/' . $post->post_name ) . '" title="' . get_the_title() . '">', '</a></h4>' );
								$short_desc = get_post_meta( get_the_ID(), 'ecpt_shortdescription', true );
								echo $short_desc;
							?>
						</div>
						<div class="download-grid-item-cta">
							<a class="download-grid-item-primary-link button gray" href="<?php echo home_url( '/downloads/' . $post->post_name ); ?>" title="<?php get_the_title(); ?>">More Information</a>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div><!-- /.extensions-grid -->
			<p class="view-all-extensions"><a class="edd-submit button blue" href="<?php echo home_url( '/downloads/' ); ?>"><i class="fa fa-plug"></i>view all extensions</a></p>
		</div>
	</div>
</div>

<?php get_footer(); ?>
