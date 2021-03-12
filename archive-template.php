<?php
/**
 * Template Name: Archive Template
 *
 * @package    10rt
 * @copyright  Copyright (c) 2021, Hélio
 * @license    unlicensed
 */

get_template_part( 'header' );
?>
				<header>
					<h1 class="archives__heading"><?php single_post_title(); ?></h1>
				</header>

				<?php

				$args = array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);

				$trt_posts = new WP_Query( $args );

				if ( $trt_posts->have_posts() ) :

					echo '<ul class="archives__list">';

					while ( $trt_posts->have_posts() ) :
						$trt_posts->the_post();

						echo '<li><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a><span>' . esc_attr( get_the_time( 'F j, Y' ) ) . '</span></li>';

					endwhile;

					echo '</ul>';

					wp_reset_postdata();

				else :
						echo '<p>' . esc_html__( 'Sorry, no posts matched your criteria.', '10rt' ) . '</p>';
				endif;
				?>


				</div><!-- .content-area -->
		</div><!-- .site-content -->
		<footer class="site-footer">

		</footer><!-- .site-footer -->
		<?php wp_footer(); ?>
	</body>
</html>
