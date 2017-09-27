<?php
/**
 * Changelog
 */

$peace = wp_get_theme( 'peace' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$peace_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$peace_changelog_lines = explode( PHP_EOL, $peace_changelog );
	foreach ( $peace_changelog_lines as $peace_changelog_line ) {
		if ( substr( $peace_changelog_line, 0, 3 ) === '###' ) {
			echo '<h4>' . substr( $peace_changelog_line, 3 ) . '</h4>';
		} else {
			echo $peace_changelog_line, '<br/>';
		}
	}

	echo '<hr />';


	?>

</div>
