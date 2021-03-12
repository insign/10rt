<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @link       https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    10rt
 * @copyright  Copyright (c) 2021, Hélio
 * @license    unlicensed
 */

get_template_part( 'header' );

				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();

						get_template_part( 'content' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile;

				else :

					get_template_part( 'content', 'none' );

				endif;
				?>

				</div><!-- .content-area -->
		</div><!-- .site-content -->
		<?php if ( get_page_by_path( 'archives' ) ) : ?>
			<footer class="site-footer">
				<a href="<?php echo esc_url( site_url( 'archives' ) ); ?>"><?php esc_html_e( 'View All Posts &rarr;', '10rt' ); ?></a>
			</footer><!-- .site-footer -->
		<?php else : ?>
			<?php trt_the_posts_navigation(); ?>
		<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>
