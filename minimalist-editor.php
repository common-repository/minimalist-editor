<?php
/**
* Plugin Name: Minimalist Editor
* Description: A minimalist Distraction Free Writing mode for the default text editor.
* Version: 1.04
* Author: oldflattop
* Author URI: http://makesmefeel.com/
**/



// admin styles
function minimalist_editor_enqueue_scripts() {
	// Retrieve this value with:
	$minimalist_editor_options = get_option( 'minimalist_editor_option_name' ); // Get array of All Options
	$plugin_url = plugin_dir_url( __FILE__ ); // set the plugin URL as a variable

	wp_enqueue_style('minimalist_editor_style' , $plugin_url . "css/minimalist-editor-main.css"); // main stylesheet
	add_editor_style( $plugin_url . "css/minimalist-editor-iframe.css"); // Tiny MCE editor stylesheet
	wp_enqueue_script('minimalist_editor_script' , $plugin_url . "js/minimalist-editor.js"); // main script
	wp_localize_script( 'minimalist_editor_script', 'options', $minimalist_editor_options ); // make options array accessible to javascirpt 
}

add_action('admin_init', 'minimalist_editor_enqueue_scripts'); // hook into admin pages



// Options page start
class MinimalistEditor {
	private $minimalist_editor_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'minimalist_editor_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'minimalist_editor_page_init' ) );
	}

	public function minimalist_editor_add_plugin_page() {
		add_theme_page(
			'Minimalist Editor', // page_title
			'Minimalist Editor', // menu_title
			'manage_options', // capability
			'minimalist-editor', // menu_slug
			array( $this, 'minimalist_editor_create_admin_page' ) // function
		);
	}

	public function minimalist_editor_create_admin_page() {
		$this->minimalist_editor_options = get_option( 'minimalist_editor_option_name' ); ?>

		<div class="wrap">
			<h2>Minimalist Editor</h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'minimalist_editor_option_group' );
					do_settings_sections( 'minimalist-editor-admin' );
					submit_button();
				?>
			</form>
			<p>Not working? Don't forget to <a href="https://make.wordpress.org/support/user-manual/content/editors/distraction-free-writing/#enabling-distraction-free-writing" target="_blank">turn on Distraction Free Writing mode</a>.</p>
		</div>
	<?php }

	public function minimalist_editor_page_init() {
		register_setting(
			'minimalist_editor_option_group', // option_group
			'minimalist_editor_option_name', // option_name
			array( $this, 'minimalist_editor_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'minimalist_editor_setting_section', // id
			'Settings', // title
			array( $this, 'minimalist_editor_section_info' ), // callback
			'minimalist-editor-admin' // page
		);

		add_settings_field(
			'darkmode_0', // id
			'Darkmode', // title
			array( $this, 'darkmode_0_callback' ), // callback
			'minimalist-editor-admin', // page
			'minimalist_editor_setting_section' // section
		);

		add_settings_field(
			'sans_serif_2', // id
			'Sans-serif', // title
			array( $this, 'sans_serif_2_callback' ), // callback
			'minimalist-editor-admin', // page
			'minimalist_editor_setting_section' // section
		);
	}

	public function minimalist_editor_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['darkmode_0'] ) ) {
			$sanitary_values['darkmode_0'] = $input['darkmode_0'];
		}

		if ( isset( $input['sans_serif_2'] ) ) {
			$sanitary_values['sans_serif_2'] = $input['sans_serif_2'];
		}

		return $sanitary_values;
	}

	public function minimalist_editor_section_info() {
		
	}

	public function darkmode_0_callback() {
		printf(
			'<input type="checkbox" name="minimalist_editor_option_name[darkmode_0]" id="darkmode_0" value="darkmode_0" %s> <label for="darkmode_0">Darkmode</label>',
			( isset( $this->minimalist_editor_options['darkmode_0'] ) && $this->minimalist_editor_options['darkmode_0'] === 'darkmode_0' ) ? 'checked' : ''
		);
	}


	public function sans_serif_2_callback() {
		printf(
			'<input type="checkbox" name="minimalist_editor_option_name[sans_serif_2]" id="sans_serif_2" value="sans_serif_2" %s> <label for="sans_serif_2">Sans-serif</label>',
			( isset( $this->minimalist_editor_options['sans_serif_2'] ) && $this->minimalist_editor_options['sans_serif_2'] === 'sans_serif_2' ) ? 'checked' : ''
		);
	}

}
if ( is_admin() )
	$minimalist_editor = new MinimalistEditor();

/* 
 * Retrieve the values from the options page with:
 * $minimalist_editor_options = get_option( 'minimalist_editor_option_name' ); // Array of All Options
 * $darkmode_0 = $minimalist_editor_options['darkmode_0']; // Darkmode
 * $sans_serif_2 = $minimalist_editor_options['sans_serif_2']; // Sans-serif
 */
