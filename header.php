<?php
/**
 * theme-wide header template
 */
?>
<!DOCTYPE html>
<!--[if IE 8 ]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.png" />
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/images/mascot/touch-icon-iphone.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/images/mascot/touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/images/mascot/touch-icon-iphone-retina.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/images/mascot/touch-icon-ipad-retina.png" />

	<?php if ( is_front_page() ) { ?>
	<meta name="apple-itunes-app" content="app-id=1169488828">
	<?php } // end if ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'eddwp_body_start' ); ?>

	<div class="header-area page-section-darkblue full-width">
		<div class="inner">
			<div class="site-header clearfix">
				<div class="site-header-inner">
					<span class="site-title">
						<?php
						if ( eddwp_edd_is_activated() ) :
							$cart_contents = edd_get_cart_contents();
						endif;
						if ( ( ! is_page_template( 'page-templates/template-checkout.php' ) || ( is_page_template( 'page-templates/template-checkout.php' ) && empty( $cart_contents ) ) ) && ! is_page_template( 'page-templates/template-barebones.php' ) ) :
							?>
							<a href="<?php echo get_option( 'siteurl' ); ?>">
								<img class="edd-logo" src="<?php echo get_stylesheet_directory_uri() . '/images/edd-logo.svg'; ?>" alt="Easy Digital Downloads" data-fallback="<?php echo get_stylesheet_directory_uri() . '/images/edd-logo.png'; ?>">
							</a>
						<?php
						else :
							?>
							<img class="edd-logo" src="<?php echo get_stylesheet_directory_uri() . '/images/edd-logo.svg'; ?>" alt="Easy Digital Downloads" data-fallback="<?php echo get_stylesheet_directory_uri() . '/images/edd-logo.png'; ?>">
						<?php
						endif;
						?>
					</span>
					<?php if ( class_exists( 'Easy_Digital_Downloads' ) && ! is_page_template( 'page-templates/template-checkout.php' ) && ! is_page_template( 'page-templates/template-barebones.php' ) ) : ?>
						<span class="header-cart">
							<a href="<?php echo home_url( '/checkout/' ); ?>"><span class="cart-qty"><?php echo edd_get_cart_quantity() ? edd_get_cart_quantity() : ''; ?></span></a>
						</span>
					<?php endif; ?>
				</div>

				<?php
					/**
					 * header navigation menu shown conditionally
					 */
					if ( ( ! is_page_template( 'page-templates/template-checkout.php' ) || ( is_page_template( 'page-templates/template-checkout.php' ) && empty( $cart_contents ) ) ) && ! is_page_template( 'page-templates/template-barebones.php' ) ) : ?>
					<i class="fa fa-bars menu-toggle"></i>
					<nav id="primary" class="navigation-main" role="navigation">
						<?php
							wp_nav_menu( array( 'theme_location' => 'primary' ) );
						?>
					</nav>
					<?php
					endif;
				?>
			</div>
		</div>
	</div>
