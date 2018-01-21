<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Peace
 */

/**
 * Customize the PageNavi HTML before it is output to support bootstrap
 */
function peace_wp_pagenavi_bootstrap_markup( $html ) {
	$out = '';

	//wrap a's and span's in li's
	$out = str_replace( '<div', '', $html );
	$out = str_replace( "class='wp-pagenavi'>", '', $out );
	$out = str_replace( '<a', '<li><a', $out );
	$out = str_replace( '</a>', '</a></li>', $out );
	$out = str_replace( '<span', '<li><span', $out );
	$out = str_replace( '</span>', '</span></li>', $out );
	$out = str_replace( '</div>', '', $out );

	return '<ul class="pagination pagination-centered wp-pagenavi-pagination">' . $out . '</ul>';
}
add_filter( 'wp_pagenavi', 'peace_wp_pagenavi_bootstrap_markup' );



if ( ! function_exists( 'peace_posted_on' ) ) :
	/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
	function peace_posted_on() {
        
		$time_string = 'Published <time class="entry-date published" datetime="%1$s">%2$s</time> ';
        
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<i class="fa fa-calendar-check-o" aria-hidden="true"></i>   Updated <time class="updated" datetime="%3$s">%4$s</time>';
		}
        
		$time_string =  sprintf( $time_string,
                                esc_attr( get_the_date( 'c' ) ),
                                esc_html( get_the_date() ),
                                esc_attr( get_the_modified_date( 'c' ) ),
                                esc_html( get_the_modified_date() )
                                );
        
        printf( '<span class="posted-on"><i class="fa fa-calendar"></i> %1$s</span>
        <span class="byline"> <i class="fa fa-user-circle"></i> %2$s</span>',
            //sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
            //    esc_url( get_permalink() ),
            sprintf( '%1$s',
                $time_string
            ),
            //sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
            //    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
              
            sprintf( '<span class="author vcard"><span class="url fn n">%1$s</span></span>',
                esc_html( get_the_author() )
            )
        );
       
	}
endif;
if ( ! function_exists( 'peace_author_name' ) ) :
	/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
	function peace_author_name() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

        // printf( '
                // <span class="posted-on"><i class="fa fa-calendar"></i> %1$s</span>
                // <span class="byline"> <i class="fa fa-user"></i> %2$s</span>',
            // sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
                // esc_url( get_permalink() ),
                // $time_string
            // )
            // ,
            // sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
                // esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                // esc_html( get_the_author() )
            // )
        // );
        printf( '
               
                <span class="byline"> <i class="fa fa-user"></i> %2$s</span>',
            sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
                esc_url( get_permalink() ),
                $time_string
            )
            ,
            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_html( get_the_author() )
            )
        );
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function peace_categorized_blog() {
	$all_the_cool_cats = get_transient( 'peace_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );
		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'peace_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so peace_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so peace_categorized_blog should return false.
		return false;
	}
}
/**
 * Flush out the transients used in peace_categorized_blog.
 */
function peace_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'peace_categories' );
}
add_action( 'edit_category', 'peace_category_transient_flusher' );
add_action( 'save_post',     'peace_category_transient_flusher' );
