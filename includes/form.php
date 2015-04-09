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
		add_action('admin_menu', array($this, 'add_submenu_page'));
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
		add_submenu_page( 'options-general.php', $menu_title, $menu_title, 'publish_posts', $menu_id, array($this, 'render') );
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