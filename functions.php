<?php
/**
 * 10rt functions and definitions
 *
 * @link       https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    10rt
 * @copyright  Copyright (c) 2021, Hélio
 * @license    unlicensed
 */

if ( ! function_exists( 'trt_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function trt_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', '10rt' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add image size for blog posts, 640px wide (and unlimited height).
		add_image_size( '10rt-blog', 640 );

		add_theme_support(
			'infinite-scroll',
			array(
				'container' => 'content-area',
				'footer'    => false,
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'trt_setup' );

/**
 * Registers an editor stylesheet for the theme.
 */
add_editor_style( 'editor-style.css' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function trt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'trt_content_width', 640 );
}
add_action( 'after_setup_theme', 'trt_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function trt_scripts() {
	wp_enqueue_style( 'trt-style', get_stylesheet_uri(), array(), '1.1.1' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'trt_scripts' );

if ( ! function_exists('trt_thumbnail') ) :
	/**
	 * Output the thumbnail if it exists.
	 *
	 * @param string $size Thunbnail size to output.
	 */
	function trt_thumbnail( $size = '' ) {

		if ( has_post_thumbnail() ) {
			?>
			<div class="post-thumbnail">

				<?php if ( ! is_single() ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( $size ); ?>
					</a>
				<?php else : ?>
					<?php the_post_thumbnail( $size ); ?>
				<?php endif; ?>

			</div><!-- .post-thumbnail -->
			<?php
		}

	}
endif;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function trt_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}

}
add_action( 'wp_head', 'trt_pingback_header' );

if ( ! function_exists('trt_the_posts_navigation') ) :
	/**
	 * Displays the navigation to next/previous set of posts, when applicable.
	 */
	function trt_the_posts_navigation() {
		$args = array(
			'prev_text'          => esc_html__( '&larr; Older Posts', '10rt' ),
			'next_text'          => esc_html__( 'Newer Posts &rarr;', '10rt' ),
			'screen_reader_text' => esc_html__( 'Posts Navigation', '10rt' ),
		);
		the_posts_navigation( $args );
	}
endif;

/**
 * Display the admin notice.
 */
function trt_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;

	if ( class_exists( 'Olympus_Google_Fonts' ) ) {
		return;
	}
	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	if ( ! get_user_meta( $user_id, 'trt_ignore_notice' ) ) {
		?>

		<div class="notice notice-info">
			<p>
				<?php
				printf(
					/* translators: 1: plugin link */
					esc_html__( 'Easily change the font of your website with our new plugin - %1$s', '10rt' ),
					'<a href="' . esc_url( admin_url( 'plugin-install.php?s=olympus+google+fonts&tab=search&type=term' ) ) . '">Fonts Plugin</a>'
				);
				?>
				<span style="float:right">
					<a href="?trt_ignore_notice=0"><?php esc_html_e( 'Hide Notice', '10rt' ); ?></a>
				</span>
			</p>
		</div>

		<?php
	}
}
add_action( 'admin_notices', 'trt_admin_notice' );
/**
 * Dismiss the admin notice.
 */
function trt_dismiss_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset( $_GET['trt_ignore_notice'] ) && '0' === $_GET['trt_ignore_notice'] ) {
		add_user_meta( $user_id, 'trt_ignore_notice', 'true', true );
	}
}
add_action( 'admin_init', 'trt_dismiss_admin_notice' );

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Triggered after the opening body tag.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

$tags_list = get_the_tag_list( '', esc_html__( ', ', '10rt' ) );
