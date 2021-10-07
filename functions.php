<?php
add_query_arg( 'checkkey', '100', true );
require_once('instruments_function.php');
/* Tell WordPress to run music_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'music_setup' );

if ( ! function_exists( 'music_setup' ) ) :
	function music_setup() {

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Blue', 'music' ),
					'slug'  => 'blue',
					'color' => '#0066cc',
				),
				array(
					'name'  => __( 'Black', 'music' ),
					'slug'  => 'black',
					'color' => '#000',
				),
				array(
					'name'  => __( 'Medium Gray', 'music' ),
					'slug'  => 'medium-gray',
					'color' => '#666',
				),
				array(
					'name'  => __( 'Light Gray', 'music' ),
					'slug'  => 'light-gray',
					'color' => '#f1f1f1',
				),
				array(
					'name'  => __( 'White', 'music' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
			)
		);

		// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
		add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( 'music', get_template_directory() . '/languages' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' 	=> 	__( 'Primary Navigation', 'music' ),
				'footer' 	=> 	__( 'Footer Nav', 'music' ),
			)
		);

		// This theme allows users to set a custom background.
		add_theme_support(
			'custom-background',
			array(
				// Let WordPress know what our default background color is.
				'default-color' => 'f1f1f1',
			)
		);

		// The custom header business starts here.

		$custom_header_support = array(
			/*
			 * The default image to use.
			 * The %s is a placeholder for the theme template directory URI.
			 */
			'default-image'       => '%s/images/headers/path.jpg',
			// The height and width of our custom header.
			/**
			 * Filter the Twenty Ten default header image width.
			 *
			 * @since Twenty Ten 1.0
			 *
			 * @param int The default header image width in pixels. Default 940.
			 */
			'width'               => apply_filters( 'music_header_image_width', 940 ),
			/**
			 * Filter the Twenty Ten defaul header image height.
			 *
			 * @since Twenty Ten 1.0
			 *
			 * @param int The default header image height in pixels. Default 198.
			 */
			   'height'           => apply_filters( 'music_header_image_height', 198 ),
			// Support flexible heights.
			'flex-height'         => true,
			// Don't support text inside the header image.
			'header-text'         => false,
			// Callback for styling the header preview in the admin.
			'admin-head-callback' => 'music_admin_header_style',
		);

		add_theme_support( 'custom-header', $custom_header_support );

		if ( ! function_exists( 'get_custom_header' ) ) {
			// This is all for compatibility with versions of WordPress prior to 3.4.
			define( 'HEADER_TEXTCOLOR', '' );
			define( 'NO_HEADER_TEXT', true );
			define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
			define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
			define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
			add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
			add_custom_background();
		}

		/*
		 * We'll be using post thumbnails for custom header images on posts and pages.
		 * We want them to be 940 pixels wide by 198 pixels tall.
		 * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
		 */
		set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

		// ... and thus ends the custom header business.

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers(
			array(
				'berries'       => array(
					'url'           => '%s/images/headers/berries.jpg',
					'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Berries', 'music' ),
				),
				'cherryblossom' => array(
					'url'           => '%s/images/headers/cherryblossoms.jpg',
					'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Cherry Blossoms', 'music' ),
				),
				'concave'       => array(
					'url'           => '%s/images/headers/concave.jpg',
					'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Concave', 'music' ),
				),
				'fern'          => array(
					'url'           => '%s/images/headers/fern.jpg',
					'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Fern', 'music' ),
				),
				'forestfloor'   => array(
					'url'           => '%s/images/headers/forestfloor.jpg',
					'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Forest Floor', 'music' ),
				),
				'inkwell'       => array(
					'url'           => '%s/images/headers/inkwell.jpg',
					'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Inkwell', 'music' ),
				),
				'path'          => array(
					'url'           => '%s/images/headers/path.jpg',
					'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Path', 'music' ),
				),
				'sunset'        => array(
					'url'           => '%s/images/headers/sunset.jpg',
					'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Sunset', 'music' ),
				),
			)
		);
	}
endif;

if ( ! function_exists( 'music_admin_header_style' ) ) :
	/**
	 * Style the header image displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_custom_image_header() in music_setup().
	 *
	 * @since Twenty Ten 1.0
	 */
	function music_admin_header_style() {
		?>
	<style type="text/css" id="music-admin-header-css">
	/* Shows the same border as on front end */
	#headimg {
		border-bottom: 1px solid #000;
		border-top: 4px solid #000;
	}
	/* If header-text was supported, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
	*/
	</style>
		<?php
	}
endif;

/**
 * Show a home link for our wp_nav_menu() fallback, wp_page_menu().
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 *
 * @param array $args An optional array of arguments. @see wp_page_menu()
 */
function music_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'music_page_menu_args' );

/**
 * Set the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 *
 * @param int $length The number of excerpt characters.
 * @return int The filtered number of excerpt characters.
 */
function music_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'music_excerpt_length' );

if ( ! function_exists( 'music_continue_reading_link' ) ) :
	/**
	 * Return a "Continue Reading" link for excerpts.
	 *
	 * @since Twenty Ten 1.0
	 *
	 * @return string "Continue Reading" link.
	 */
	function music_continue_reading_link() {
		return ' <a href="' . get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'music' ) . '</a>';
	}
endif;

/**
 * Replace "[...]" with an ellipsis and music_continue_reading_link().
 *
 * "[...]" is appended to automatically generated excerpts.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $more The Read More text.
 * @return string An ellipsis.
 */
function music_auto_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		return ' &hellip;' . music_continue_reading_link();
	}
	return $more;
}
add_filter( 'excerpt_more', 'music_auto_excerpt_more' );

/**
 * Add a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $output The "Coninue Reading" link.
 * @return string Excerpt with a pretty "Continue Reading" link.
 */
function music_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() && ! is_admin() ) {
		$output .= music_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'music_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function music_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) ) {
	add_filter( 'gallery_style', 'music_remove_gallery_css' );
}

if ( ! function_exists( 'music_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own music_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Ten 1.0
	 *
	 * @param object $comment The comment object.
	 * @param array  $args    An array of arguments. @see get_comment_reply_link()
	 * @param int    $depth   The depth of the comment.
	 */
	function music_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '':
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'music' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'music' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'music' ), get_comment_date(), get_comment_time() );
				?>
					</a>
					<?php
					edit_comment_link( __( '(Edit)', 'music' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->

				<div class="comment-body"><?php comment_text(); ?></div>

				<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						)
					)
				);
				?>
				</div><!-- .reply -->
			</div><!-- #comment-##  -->

				<?php
				break;
			case 'pingback':
			case 'trackback':
				?>
		<li class="post pingback">
		<p><?php _e( 'Pingback:', 'music' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'music' ), ' ' ); ?></p>
				<?php
				break;
		endswitch;
	}
endif;


function music_widgets_init() {
	//Area 1, located at the top of the sidebar.
	register_sidebar(
		array(
			'name'          => __( 'Footer Copyright', 'music' ),
			'id'            => 'footercopy',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'music' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'music_widgets_init' );


if ( ! function_exists( 'music_posted_on' ) ) :
	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 *
	 * @since Twenty Ten 1.0
	 */
	function music_posted_on() {
		printf(
			__( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'music' ),
			'meta-prep meta-prep-author',
			sprintf(
				'<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf(
				'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'music' ), get_the_author() ) ),
				get_the_author()
			)
		);
	}
endif;

if ( ! function_exists( 'music_posted_in' ) ) :
	/**
	 * Print HTML with meta information for the current post (category, tags and permalink).
	 *
	 * @since Twenty Ten 1.0
	 */
	function music_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list && ! is_wp_error( $tag_list ) ) {
			$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'music' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'music' );
		} else {
			$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'music' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

/**
 * Retrieve the IDs for images in a gallery.
 *
 * @uses get_post_galleries() First, if available. Falls back to shortcode parsing,
 *                            then as last option uses a get_posts() call.
 *
 * @since Twenty Ten 1.6.
 *
 * @return array List of image IDs from the post gallery.
 */
function music_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) ) {
			$images = explode( ',', $galleries[0]['ids'] );
		}
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) ) {
			$images = explode( ',', $atts['ids'] );
		}
	}

	if ( ! $images ) {
		$images = get_posts(
			array(
				'fields'         => 'ids',
				'numberposts'    => 999,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_mime_type' => 'image',
				'post_parent'    => get_the_ID(),
				'post_type'      => 'attachment',
			)
		);
	}

	return $images;
}

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Ten 2.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function music_widget_tag_cloud_args( $args ) {
	$args['largest']  = 22;
	$args['smallest'] = 8;
	$args['unit']     = 'pt';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'music_widget_tag_cloud_args' );

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Twenty Ten 2.6
 */
function music_scripts_styles() {
	// Theme block stylesheet.
	wp_enqueue_style( 'music-block-style', get_template_directory_uri() . '/blocks.css', array(), '20181018' );
}
add_action( 'wp_enqueue_scripts', 'music_scripts_styles' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Twenty Ten 2.6
 */
function music_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'music-block-editor-style', get_template_directory_uri() . '/editor-blocks.css' );
}
add_action( 'enqueue_block_editor_assets', 'music_block_editor_styles' );

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since Twenty Ten 2.9
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Twenty Ten 2.9
		 */
		do_action( 'wp_body_open' );
	}
endif;
function add_admin_css(){
	?>
		<style>
		#send-email label {
    display: inline-block;
    margin: 0;
    padding: 10px 40px;
    border: 1px solid #000;
    text-transform: uppercase;
    border-radius: 100px;
}

#send-email label:hover {
    background: #000;
    color: #fff;
}
			</style>		
	<?php
}
add_action('admin_head','add_admin_css');



// Function to change email address
 
function wpb_sender_email( $original_email_address ) {
    return 'info@houseofnote.com';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'House Of Note';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

function my_login_logo_one() { 
?> 
    <style type="text/css"> 
		body {
			background: #000 !important;
		}
		body.login div#login h1 a {
           background-image: url(https://houseofnote.com/rentals/wp-content/uploads/2020/04/houseofnote.png);
    padding-bottom: 0;
    background-size: contain;
    width: 310px;
    margin-bottom: 0;
    height: 140px;
        } 
    </style>
 <?php 
} 
add_action( 'login_enqueue_scripts', 'my_login_logo_one' );