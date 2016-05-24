<?php
/**
 * The template part for displaying content
 * 
 * @package Estudio_Viking_WP
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="container">
			<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title h1"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) :
					evwp_posted_on();
				endif;
			?>
		</div>
	</header><!-- .entry-header -->

	<?php evwp_excerpt(); ?>

	<div class="entry-content">
		<div class="container">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					__( 'Continue reading', ID_THEME_NAME ) . ' %s <span class="meta-nav">&hellip;</span>',
					the_title( '<span class="sr-only sr-only-focusable">"', '"</span>', false )
				) );
			?>
	
			<div class="page-links">
				<?php
					wp_link_pages( array(
						'before' => '<ul class="pager"><li class="disabled"><span class="page-links-title">' . esc_html__( 'Pages:', ID_THEME_NAME ) . '</span></li>',
						'after'  => '</ul>',
					) );
				?>
			</div>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="container">
			<?php evwp_entry_footer(); ?>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
