<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link       https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    10rt
 * @copyright  Copyright (c) 2021, Hélio
 * @license    unlicensed
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', '10rt' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				/* translators: %s: link to new post admin screen */
				printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', '10rt' ), array(
					'a' => array(
						'href' => array(),
					),
				) ), esc_url( admin_url( 'post-new.php' ) ) );
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php
				esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', '10rt' );
				?>
			</p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p>
				<?php
				esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', '10rt' );
				?>
			</p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->
</section><!-- .no-results -->
