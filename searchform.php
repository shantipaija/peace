<?php
/**
 * The template for displaying search forms in Peace
 *
 * @package Peace
 */
?>

<form role="search" method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="input-group">
	  <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'peace' ); ?></label>
	<input type="text" class="form-control search-query" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'peace' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'peace' ); ?>" />
	<span class="input-group-btn">
	  <button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'peace' ); ?>"><span class="glyphicon glyphicon-search"></span></button>
	</span>
  </div>
</form>
