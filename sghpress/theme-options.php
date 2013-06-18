<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'SGHpress_options', 'SGHpress_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'St George\s Hospital Options' ), __( 'St George\'s Hospital Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}


/**
 * Create the options page
 */
function theme_options_do_page() {

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>SGH" . __( ' Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'SGHpress_options' ); ?>
			<?php $options = get_option( 'SGHpress_theme_options' ); ?>

			<table class="form-table">

				<!-- 	Google Analytics tracking code -->
	
				<tr valign="top"><th scope="row"><?php _e( 'Google Analytics tracking code' ); ?></th>
					<td>
						<textarea id="SGHpress_theme_options[analyticscode]" class="large-text" cols="50" rows="10" name="SGHpress_theme_options[analyticscode]"><?php echo stripslashes( $options['analyticscode'] ); ?></textarea>
						<label class="description" for="SGHpress_theme_options[analyticscode]"><?php _e( 'Tracking code for analytics' ); ?></label>
					</td>
				</tr>

				<!-- -->

				<!-- 	Custom CSS  -->
	
				<tr valign="top"><th scope="row"><?php _e( 'Advanced: custom CSS rules' ); ?></th>
					<td>
						<textarea id="SGHpress_theme_options[customcss]" class="large-text" cols="50" rows="10" name="SGHpress_theme_options[customcss]"><?php echo stripslashes( $options['customcss'] ); ?></textarea>
						<label class="description" for="SGHpress_theme_options[customcss]"><?php _e( 'Custom CSS rules (advanced users only)' ); ?></label>
					</td>
				</tr>

				<!-- -->

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {

	return $input;
}

