<div class="qbppc-form">
	<div class="wrap">
		<h2><?php echo $qbppc->get_form()->get_menu_title(); ?></h2>

		<p><?php _e('Please, select a post type and input your preferred hierarchy.', 'qbppc'); ?></p>

		<form method="post" action="options.php">
			<?php 
			settings_fields( $qbppc->get_form()->get_menu_id() );
			do_settings_sections( $qbppc->get_form()->get_menu_id() );
			submit_button(__('Bulk Insert', 'qbppc')); 
			?>
		</form>

	</div>
</div>