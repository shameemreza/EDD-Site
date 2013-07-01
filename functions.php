<?php
/**
 * EDD functions and definitions
 *
 * @package	  EasyDigitalDownloads_v2
 * @category  Core
 * @author	  Sunny Ratilal
 * @copyright Copyright (c) 2013, Sunny Ratilal.
 */

/**
 * Set the content width.
 */
if ( ! isset( $content_width ) )
	$content_width = 680;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function edd_theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	add_editor_style( 'css/editor-style.css' );
	
	add_image_size( 'showcase', 320, 200, true );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'edd' ),
	) );
}
add_action( 'after_setup_theme', 'edd_theme_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function edd_register_theme_sidebars() {
	register_sidebar( array(
		'name'		  => __( 'Blog Sidebar', 'edd' ),
		'id'			  => 'blog-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'	  => '</h3>'
	) );

	register_sidebar( array(
		'name'		  => __( 'Forums Sidebar', 'edd' ),
		'id'			  => 'forum-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'	  => '</h3>',
	) );

	register_sidebar( array(
		'name'		  => __( 'Documentation Sidebar', 'edd' ),
		'id'			  => 'documentation-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'	  => '</h3>',
	) );
}
add_action( 'widgets_init', 'edd_register_theme_sidebars' );

/**
 * Enqueue scripts and styles
 */
function edd_register_theme_scripts() {
	wp_register_style( 'roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:400,300,500' );
	wp_register_style( 'edd-style', get_stylesheet_directory_uri() . '/style.css', array( 'roboto-font' ), '1.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/lib/font-awesome.css', array( 'edd-style' ) );
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/lib/normalize.css' );

	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'roboto-font' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'edd-style' );

	wp_register_script( 'edd-js', get_template_directory_uri() . '/js/theme.min.js', array( 'jquery' ) );
	wp_register_script( 'modernizr-js', get_template_directory_uri() . '/js/lib/modernizr.min.js', array( 'jquery' ) );
	wp_register_script( 'nivo-slider-js', get_template_directory_uri() . '/js/lib/nivoslider.min.js', array( 'jquery' ) );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'edd-js' );
	wp_enqueue_script( 'modernizr-js' );

	if ( is_front_page() )
		wp_enqueue_script( 'nivo-slider-js' );

	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'edd_register_theme_scripts' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function edd_wp_title( $title, $sep ) {
	global $paged, $page, $post;

	$title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );

	if ( is_search() || isset( $_GET['extension_s'] ) ) {
		if ( is_search() ) $search_term = get_query_var( 's' );
		
		if ( isset( $_GET['extension_s'] ) ) $search_term = $_GET['extension_s'];

		$title = __( 'Search Results For' , 'edd' ) . ' ' . $search_term . ' | ' . get_bloginfo( 'name' );
	} elseif ( is_home() || is_front_page() ) {
		$title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
	} elseif ( is_page() ) {
		$title = strip_tags( htmlspecialchars_decode( get_the_title( $post->ID ) ) ) . ' | ' . get_bloginfo( 'name' );
	} elseif ( is_404() ) {
		$title = __( '404 - Nothing Found', 'edd' ) . ' | ' . get_bloginfo( 'name' );
	} elseif ( is_author() ) {
		$title = get_userdata( get_query_var( 'author' ) )->display_name . ' | ' . __( 'Author Archive', 'edd' )	. ' | ' . get_bloginfo( 'name' );
	} elseif ( is_category() ) {
		$title = single_cat_title( '', false ) . ' | ' . __( 'Category Archive', 'edd' ) . ' | ' . get_bloginfo( 'name' );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false ) . ' | ' . __( 'Tag Archive', 'edd' ) . ' | ' . get_bloginfo( 'name' );
	} elseif ( is_single() ) {
		$post_title = the_title_attribute( 'echo=0' );

		if ( ! empty( $post_title ) )
			$title = $post_title . ' | ' . get_bloginfo( 'name' );
	}

	if ( is_feed() )
		return $title;

	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'edd' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'edd_wp_title', 10, 2 );

function edd_image_full_quality( $quality ) {
	return 100;
}
add_filter( 'jpeg_quality', 'edd_image_full_quality' );
add_filter( 'wp_editor_set_quality', 'edd_image_full_quality' );

function eddwp_get_latest_post() {
	$query = new WP_Query( array( 'posts_per_page' => 1 ) );

	while ( $query->have_posts() ) {
		$query->the_post();
		printf( '<h4>%s</h4>', get_the_title() );
		the_excerpt();
		printf( '<a href="%1$s">%2$s</a>', get_permalink(), __( 'Read More...', 'edd' ) );
	}
}

function eddwp_get_footer_nav() {  }

function eddwp_extensions_cb() {
	echo '<div class="extensions clearfix">';
	$extensions =	new WP_Query( array( 'post_type' => 'extension', 'nopaging' => true, 'orderby' => 'rand' ) );
	while ( $extensions ->have_posts() ) {
		$extensions->the_post();
		?>
		<div class="extension">
			<a href="<?php the_permalink(); ?>" title="<?php get_the_title(); ?>">
				<?php the_post_thumbnail( 'showcase' ); ?>
				<h2><?php the_title(); ?></h2>
				<?php the_excerpt(); ?>
			</a>
		</div>
		<?php
	}
	?>
	
	<?php
	echo '</div>';
}
add_shortcode( 'extensions', 'eddwp_extensions_cb' );

function eddwp_add_rewrite_tags() {
	add_rewrite_tag( '%extension_s%', '([^/]+)' );
}
add_action( 'init', 'eddwp_add_rewrite_tags' );

function eddwp_process_rewrites() {
	if ( isset( $_GET[ 'extension_s' ] ) && ! empty ( $_GET['extension_s'] ) && isset( $_GET['action'] ) && $_GET['action'] == 'extension_search' ) {
		load_template( dirname( __FILE__ ) . '/search-extensions.php' );
		die();
	}
}
add_action( 'init', 'eddwp_process_rewrites' );

class SR_Newsletter_Signup_Form extends WP_Widget {
	public function __construct() {
		parent::WP_Widget( false, __('MailChimp Sign Up Form (Sidebar)', 'edd' ) );
	}
	
		 /** @see WP_Widget::widget */
	public function widget($args, $instance) {	
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$list_id = strip_tags($instance['list_id']);
		$message = esc_attr($instance['message']);
		
			global $post;		 
		
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		echo sr_mc_form('', $list_id, $message);
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	public function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['list_id'] = strip_tags($new_instance['list_id']);
		$instance['message'] = esc_attr($new_instance['message']);
	  return $instance;
	}

	/** @see WP_Widget::form */
	public function form($instance) {	
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$description = isset($instance['description']) ? esc_attr($instance['description']) : '';
		$list_id = isset($instance['list_id']) ? esc_attr($instance['list_id']) : '';
		$message = isset($instance['message']) ? esc_attr($instance['message']) : '';
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'pmc'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'pmc'); ?></label> <br />
				<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo $description; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('list_id'); ?>"><?php _e('Choose a List', 'pmc'); ?></label> 
				<select name="<?php echo $this->get_field_name('list_id'); ?>" id="<?php echo $this->get_field_id('list_id'); ?>" class="widefat">
				<?php
					$lists = pmc_get_lists();
					foreach ($lists as $id => $list) {
						echo '<option value="' . $id . '"' . selected($list_id, $id, false) . '>' . $list . '</option>';
					}
				?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Success Message:', 'pmc'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo $message; ?>" />
			</p>

		<?php 
	}
}

function eddwp_body_class( $classes ) {
	if ( isset( $_GET['extension_s'] ) ) {
		$classes[] = 'extension-search';
	}

	if ( is_page( 'support' ) ) {
		$classes[] = 'bbpress';
	}
	
	if ( is_single() ) {
		$classes[] = 'blog';
	}
	
	return $classes;
}
add_filter( 'body_class', 'eddwp_body_class' );

function eddwp_bbp_get_forum_freshness_link( $anchor, $forum_id, $time_since, $link_url, $title, $active_id ) {
	if ( ! empty( $time_since ) && ! empty( $link_url ) )
		$anchor = '<a href="' . $link_url . '" title="' . esc_attr( $title ) . '">' . 'Last response ' . $time_since . '</a>';
	else
		$anchor = __( 'No Topics', 'edd' );
	
	return $anchor;
}
add_filter( 'bbp_get_forum_freshness_link', 'eddwp_bbp_get_forum_freshness_link', 10, 6 );

function eddwp_support_admin_bar( $wp_admin_bar ) {
	global $user_ID;

	$wp_admin_bar->add_node(
		array(
			'id'	 =>	'eddwp_support',
			'title'	 =>	__( 'Support Tickets' ),
			'href'	 =>	'/support/dashboard/'
		)
	);

	$args = array(
		'post_type'  => 'topic',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => '_bbps_topic_status',
				'value' => '1',
			),
			array(
				'key'   => 'bbps_topic_assigned',
				'value' => $user_ID,
			)
		),
		'posts_per_page' => -1
	);
	
	$assigned_tickets = new WP_Query( $args );

	$wp_admin_bar->add_node(
		array(
			'id'	 =>	'assigned_tickets',
			'parent' => 'eddwp_support',
			'title'	 =>	__( 'Assigned Tickets (' . $assigned_tickets->post_count . ')' ),
			'href'	 =>	'/support/dashboard/#your_tickets'
		)
	);
	
	while ( $assigned_tickets->have_posts() ) {
		$assigned_tickets->the_post();
		
		$wp_admin_bar->add_node(
			array(
				'id' => 'support_ticket_' . get_the_ID(),
				'title' => get_the_title(),
				'href' => get_permalink(),
				'parent' => 'assigned_tickets'
			)
		);
	}

	$args = array(
		'post_type'  => 'topic',
		'meta_key'   => '_bbps_topic_status',
		'meta_value' => '1',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);

	$o = new WP_Query( $args );

	$wp_admin_bar->add_node(
		array(
			'id'	 =>	'unresolved_tickets',
			'parent' => 'eddwp_support',
			'title'	 =>	__( 'Unresolved Tickets (' . $o->post_count . ')' ),
			'href'	 =>	'/support/dashboard/'
		)
	);
}
add_action( 'admin_bar_menu', 'eddwp_support_admin_bar', 999 );

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function edd_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class( 'clearfix' ); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php the_ID(); ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $args['avatar_size'] );?>
				<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
		 	</div><!-- /.comment-author -->

		 	<div class="comment-meta commentmetadata">
				<a class="comment-date" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() ); ?></a>
				<?php edit_comment_link( __( '(Edit)' ), '' ); ?>
		 	</div>
	
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="alert"><?php echo apply_filters( 'eddwp_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'edd' ) ); ?></p>
			<?php endif; ?>

			<?php
			
			comment_text();
			
			comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<p>Reply</p>' ) ) );
			
			?>
		</div>
<?php
}

function eddwp_comment_form() {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<p class="comment-form-author"><label for="author">' . __( 'Name', 'flat' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'flat' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'flat' ) . '</label>' . '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	comment_form( array( 'fields' => apply_filters( 'comment_form_default_fields', $fields ) ) );
}