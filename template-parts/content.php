<?php
/**
 * @package Peace
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="imghov">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php
				if ( is_page_template( 'page-fullwidth.php' ) ) {
					the_post_thumbnail( 'peace-featured-fullwidth', array(
						'class' => 'single-featured',
					) );
				} else {
                    the_post_thumbnail( 'peace-featured', array(
						'class' => 'single-featured  featured-loop',
						
					) );
				}
				?>
                </a>
            </div>
        <?php endif; ?>
		<div class="post-inner-content">
			<header class="entry-header page-header">

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php peace_posted_on(); ?><?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link"><i class="fa fa-comment-o"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'peace' ), esc_html__( '1 Comment', 'peace' ), esc_html__( '% Comments', 'peace' ) ); ?></span>
				<?php endif; ?>

				<?php if ( get_edit_post_link() ) : ?>
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'peace' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<i class="fa fa-pencil-square-o"></i><span class="edit-link">',
							'</span>'
						);
					?>
				<?php endif; ?>

				</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'peace' ); ?></a></p>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">

				<?php
				if ( get_theme_mod( 'peace_excerpts' ) == 1 ) :
					the_excerpt();?>
					<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read More', 'peace' ); ?></a></p>
				<?php else :
					the_content( esc_html__( 'Read More', 'peace' ) );
				endif;
					?>

				<?php
					wp_link_pages( array(
						'before'            => '<div class="page-links">' . esc_html__( 'Pages:', 'peace' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1,
					) );
				?>
			</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->
