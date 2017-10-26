<?php
/**
 * Actions required
 */
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">

	<?php
	global $peace_required_actions, $peace_recommended_plugins;
	if ( ! empty( $peace_required_actions ) ) :
		/* peace_show_required_actions is an array of true/false for each required action that was dismissed */
		$nr_actions_required = 0;
		$nr_action_dismissed = 0;
		$peace_show_required_actions = get_option( 'peace_show_required_actions' );
		foreach ( $peace_required_actions as $peace_required_action_key => $peace_required_action_value ) :
			$hidden = false;
			if ( isset( $peace_show_required_actions[ $peace_required_action_value['id'] ] ) && false === $peace_show_required_actions[ $peace_required_action_value['id'] ] ) {
				$hidden = true;
			}
			if ( isset( $peace_required_action_value['check'] ) && $peace_required_action_value['check'] ) {
				continue;
			}
			$nr_actions_required ++;
			if ( $hidden ) {
				$nr_action_dismissed ++;
			}

			?>
			<div class="peace-action-required-box">
				<?php if ( ! $hidden ) : ?>
					<span data-action="dismiss" class="dashicons dashicons-visibility peace-required-action-button"
						  id="<?php echo esc_attr( $peace_required_action_value['id'] ); ?>"></span>
				<?php else : ?>
					<span data-action="add" class="dashicons dashicons-hidden peace-required-action-button"
						  id="<?php echo esc_attr( $peace_required_action_value['id'] ); ?>"></span>
				<?php endif; ?>
				<h3><?php if ( ! empty( $peace_required_action_value['title'] ) ) : echo $peace_required_action_value['title'];
endif; ?></h3>
				<p>
					<?php if ( ! empty( $peace_required_action_value['description'] ) ) : echo $peace_required_action_value['description'];
endif; ?>
					<?php if ( ! empty( $peace_required_action_value['help'] ) ) : echo '<br/>' . $peace_required_action_value['help'];
endif; ?>
				</p>
				<?php
				if ( ! empty( $peace_required_action_value['plugin_slug'] ) ) {
					$active = $this->check_active( $peace_required_action_value['plugin_slug'] );
					$url    = $this->create_action_link( $active['needs'], $peace_required_action_value['plugin_slug'] );
					$label  = '';
					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = __( 'Install', 'peace' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = __( 'Activate', 'peace' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = __( 'Deactivate', 'peace' );
							break;
					}
					?>
					<p class="plugin-card-<?php echo esc_attr( $peace_required_action_value['plugin_slug'] ) ?> action_button <?php echo ( 'install' !== $active['needs'] && $active['status'] ) ? 'active' : '' ?>">
						<a data-slug="<?php echo esc_attr( $peace_required_action_value['plugin_slug'] ) ?>"
						   class="<?php echo $class; ?>"
						   href="<?php echo esc_url( $url ) ?>"> <?php echo $label ?> </a>
					</p>
					<?php
				};
				?>
			</div>
			<?php
		endforeach;
	endif;
	$nr_recommended_plugins = 0;
	if ( 0 == $nr_actions_required || $nr_actions_required == $nr_action_dismissed ) :

		$peace_show_recommended_plugins = get_option( 'peace_show_recommended_plugins' );
		foreach ( $peace_recommended_plugins as $slug => $plugin_opt ) {

			if ( ! $plugin_opt['recommended'] ) {
				continue;
			}

			if ( peace_Notify_System::has_plugin( $slug ) ) {
				continue;
			}
			if ( 0 == $nr_recommended_plugins ) {
				echo '<h3 class="hooray">' . __( 'Hooray! There are no required actions for you right now. But you can make your theme more powerful with next actions: ', 'peace' ) . '</h3>';
			}

			$nr_recommended_plugins ++;
			echo '<div class="peace-action-required-box">';

			if ( isset( $peace_show_recommended_plugins[ $slug ] ) && $peace_show_recommended_plugins[ $slug ] ) : ?>
				<span data-action="add" class="dashicons dashicons-hidden peace-recommended-plugin-button"
					  id="<?php echo esc_attr( $slug ); ?>"></span>
			<?php else : ?>
				<span data-action="dismiss" class="dashicons dashicons-visibility peace-recommended-plugin-button"
					  id="<?php echo esc_attr( $slug ); ?>"></span>
			<?php endif;

			$active = $this->check_active( $slug );
			$url    = $this->create_action_link( $active['needs'], $slug );
			$info   = $this->call_plugin_api( $slug );
			$label  = '';
			$class = '';
switch ( $active['needs'] ) {
	case 'install':
		$class = 'install-now button';
		$label = __( 'Install', 'peace' );
		break;
	case 'activate':
		$class = 'activate-now button button-primary';
		$label = __( 'Activate', 'peace' );
		break;
	case 'deactivate':
		$class = 'deactivate-now button';
		$label = __( 'Deactivate', 'peace' );
		break;
}
			?>
			<h3><?php echo $label . ': ' . $info->name ?></h3>
			<p>
				<?php echo $info->short_description ?>
			</p>
			<p class="plugin-card-<?php echo esc_attr( $slug ) ?> action_button <?php echo ( 'install' !== $active['needs'] && $active['status'] ) ? 'active' : '' ?>">
				<a data-slug="<?php echo esc_attr( $slug ) ?>"
				   class="<?php echo $class; ?>"
				   href="<?php echo esc_url( $url ) ?>"> <?php echo $label ?> </a>
			</p>
			<?php

			echo '</div>';

		}// End foreach().

	endif;

	if ( 0 == $nr_recommended_plugins && 0 == $nr_actions_required ) {
		echo '<span class="hooray">' . __( 'Hooray! There are no required actions for you right now.', 'peace' ) . '</span>';
	}

	?>

</div>
