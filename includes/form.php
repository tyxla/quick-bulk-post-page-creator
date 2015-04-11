<?php
/**
 * Class for setting up the settings page with the main form.
 */
class QBPPC_Form {

	/**
	 * Constructor.
	 *	
	 * Initializes the admin form functionality.
	 *
	 * @access public
	 */
	public function __construct() {
		// hook the main plugin page
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );

		// register settings fields & sections
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Get the title of the submenu item page.
	 *
	 * @access public
	 *
	 * @return string $menu_title The title of the submenu item.
	 */
	public function get_menu_title() {
		// allow filtering the title of the submenu page
		$menu_title = apply_filters('qbppc_menu_item_title', __('Quick Post Creator', 'qbppc'));

		return $menu_title;
	}

	/**
	 * Get the ID (slug) of the submenu item page.
	 *
	 * @access public
	 *
	 * @return string $menu_id The ID (slug) of the submenu item.
	 */
	public function get_menu_id() {
		return 'qbppc';
	}

	/**
	 * Register the main plugin submenu page.
	 *
	 * @access public
	 */
	public function add_submenu_page() {
		$menu_title = $this->get_menu_title();
		$menu_id = $this->get_menu_id();

		// register the submenu page - child of the Settings parent menu item
		add_submenu_page(
			'options-general.php',
			$menu_title,
			$menu_title,
			'publish_posts',
			$menu_id,
			array($this, 'render')
		);

		// register settings section
		add_settings_section(
			$menu_id,
			'',
			'',
			$menu_id
		);

	}

	/**
	 * Get field data. Defines and describes the fields that will be registered.
	 *
	 * @access public
	 *
	 * @return array $fields The fields and their data.
	 */
	public function get_field_data() {
		return array(
			'hierarchy_indent_character' => array(
				'type' => 'text',
				'title' => 'Hierarchy Indent Character',
				'default' => '*',
				'help' => 'You can use this character at the beginning of your entry to specify hierarchy indentation.',
			),
			'post_type' => array(
				'type' => 'select',
				'title' => 'Post Type',
				'default' => '',
				'help' => 'The post type that you want to bulk insert entries into.',
				'options' => QBPPC_Posts::get_post_types(),
			),
			'pages' => array(
				'type' => 'textarea',
				'title' => 'Entries (one per line)',
				'default' => '',
				'help' => 'A hierarchical list of your entries.',
			),
		);
	}

	/**
	 * Register the settings sections and fields.
	 *
	 * @access public
	 */
	public function register_settings() {
		// register fields
		$field_data = $this->get_field_data();
		foreach ($field_data as $field_id => $field) {
			$field_object = QBPPC_Field::factory($field['type'], 'qbppc_' . $field_id, $field['title'], $this->get_menu_id(), $this->get_menu_id());
			if (isset($field['options'])) {
				$field_object->set_options($field['options']);
			}
			$this->fields[] = $field_object;
		}
	}

	/**
	 * Render the settings page with the form.
	 *
	 * @access public
	 */
	public function render() {
		global $qbppc;

		// determine the form template
		$template = $qbppc->get_plugin_path() . '/templates/form.php';
		$template = apply_filters('qbppc_main_template', $template);

		// render the form template
		include_once($template);
	}

}