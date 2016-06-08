<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Estudio_Viking_WP
 * @since 1.0.0
 */

if ( ! function_exists( 'evwp_edit_link' ) ) :
/**
 * Custom edit links
 * 
 * @since 1.0.0
 * ----------------------------------------------------------------------------
 */
function evwp_edit_link( $type, $tag = 'span' ) {
	/**
	 * Filter the list of HTML tags that are valid for use as link containers.
	 *
	 * @since 1.0.0
	 *
	 * @param array $tags The acceptable HTML tags for use as link containers.
	 *                    Default is array containing 'div', 'li' and 'span'.
	 */
	$allowed_tags = apply_filters( 'evwp_edit_link_allowedtags', array( 'div', 'li', 'span' ) );
	if ( is_string( $tag ) && in_array( $tag, $allowed_tags ) ) {
		if ( $type = 'post' ) {
			edit_post_link(
				__( 'Edit', 'evwp' ),
				'<' . $tag . ' class="edit-link"><span class="glyphicon glyphicon-pencil"></span>',
				'</' . $tag . '>'
			);
		}
	}
}
endif;


if ( ! function_exists( 'evwp_comments_link' ) ) :
/**
 * Custom comment links
 * 
 * @since 1.0.0
 * ----------------------------------------------------------------------------
 */
function evwp_comments_link() {
	if ( comments_open( get_the_ID() ) )
		comments_popup_link(
			__( 'Leave your thoughts', 'evwp' ),
			__( '1 comment', 'evwp' ),
			__( '% comments', 'evwp' )
		);
}
endif;


if ( ! function_exists( 'evwp_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function evwp_posted_on() {
?>
	<p class="entry-meta small">
		<span class="entry-author"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php the_author_posts_link(); ?></span>
		<span class="entry-date"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><?php id_date_link(); ?></span>
		<span class="entry-categ"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span><?php the_category( ', ' ); ?></span>
		<span class="entry-comments"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span><?php evwp_comments_link(); ?></span>
		<?php evwp_edit_link( 'post' ); ?>
	</p><!-- .entry-meta -->
<?php
}
endif;


if ( ! function_exists( 'evwp_excerpt' ) ) :
/**
 * Displays the optional excerpt.
 *
 * Wraps the excerpt in a div element.
 *
 * Create your own evwp_excerpt() function to override in a child theme.
 *
 * @since 1.0.0
 *
 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
 */
function evwp_excerpt( $class = 'entry-summary' ) {
	$class = esc_attr( $class );

	if ( has_excerpt() || is_search() ) : ?>
		<div class="<?php echo $class; ?>">
			<div class="container">
				<?php the_excerpt(); ?>
			</div>
		</div><!-- .<?php echo $class; ?> -->
	<?php endif;
}
endif;


if ( ! function_exists( 'evwp_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * Create your own evwp_excerpt_more() function to override in a child theme.
 *
 * @since 1.0.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function evwp_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'evwp' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'evwp_excerpt_more' );
endif;


if ( ! function_exists( 'evwp_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function evwp_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'evwp' ) );
		if ( $categories_list && evwp_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'evwp' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'evwp' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'evwp' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'evwp' ), esc_html__( '1 Comment', 'evwp' ), esc_html__( '% Comments', 'evwp' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'evwp' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function evwp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'evwp_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'evwp_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so evwp_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so evwp_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in evwp_categorized_blog.
 */
function evwp_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'evwp_categories' );
}
add_action( 'edit_category', 'evwp_category_transient_flusher' );
add_action( 'save_post',     'evwp_category_transient_flusher' );
