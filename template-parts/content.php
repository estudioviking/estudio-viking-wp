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
		<div class="entry-header-container container">
			<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h3 class="entry-title h1"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				endif;

				if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php evwp_posted_on(); ?>
					</div><!-- .entry-meta --><?php
				endif;
			?>
		</div><!-- .entry-header-container -->
	</header><!-- .entry-header -->

	<div class="entry-content container">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'estudio-viking-wp' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
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
	</div><!-- .entry-content -->

	<footer class="entry-footer container">
		<?php evwp_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
