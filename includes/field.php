<?php
/**
 * Manages administration settings page field registration.
 * Should be extended for each field type.
 *
 * @abstract
 */
abstract class QBPPC_Field {

	/**
	 * Field title.
	 *
	 * @access protected
	 * @var string
	 */
	protected $title;

	/**
	 * Field ID.
	 *
	 * @access protected
	 * @var string
	 */
	protected $id;


	/**
	 * Constructor.
	 *
	 * Register an administration settings field.
	 *
	 * @access public
	 *
	 * @param string $id The ID of the field.
	 * @param string $title The title of the field.
	 * @param string $page_id ID of the settings page.
	 * @param string $section The name of the section.
	 * @param array $args Additional args.
	 */
	public function __construct($id, $title, $page_id, $section = '', $args = array()) {

		$this->set_id($id);
		$this->set_title($title);

		add_settings_field( 
			$id,
			$title,
			array($this, 'render'),
			$page_id,
			$section,
			$args
		);

		register_setting( $page_id, $id );
	}

	/**
	 * Register a new administration settings field of a certain type.
	 *
	 * @static
	 *
	 * @param string $type Type of the field.
	 * @param string $id The ID of the field.
	 * @param string $title The title of the field.
	 * @param string $page_id ID of the settings page.
	 * @param string $section The name of the section.
	 * @param array $args Additional args.
	 * @return QBPPC_Field $field
	 */
	static function factory($type, $id, $title, $page_id, $section = '', $args = array()) {
		$type = str_replace(" ", '', ucwords(str_replace("_", ' ', $type)));

		$class = 'QBPPC_Field_' . $type;

		if (!class_exists($class)) {
			throw new Exception('Unknown settings field type "' . $type . '".');
		}

		$field = new $class($id, $title, $page_id, $section, $args);

		return $field;
	}

	/**
	 * Retrieve the field title.
	 *
	 * @access public
	 *
	 * @return string $title The title of this field.
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Modify the title of this field.
	 *
	 * @access public
	 *
	 * @param string $title The new title.
	 */
	public function set_title($title) {
		$this->title = $title;
	}

	/**
	 * Retrieve the field ID.
	 *
	 * @access public
	 *
	 * @return string $id The ID of this field.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Modify the ID of this field.
	 *
	 * @access public
	 *
	 * @param string $id The new ID.
	 */
	public function set_id($id) {
		$this->id = $id;
	}

	/**
	 * Retrieve the field value. If there is no value, use the default one.
	 *
	 * @access public
	 *
	 * @return mixed $value The value of this field.
	 */
	public function get_value() {
		global $qbppc;
		$field_data = $qbppc->get_form()->get_field_data();
		$original_name = str_replace('qbppc_', '', $this->get_id());

		$default = !empty($field_data[$original_name]['default']) ? $field_data[$original_name]['default'] : '';

		$value = get_option($this->get_id());
		if ($value === false) {
			$value = $default;
		}

		return $value;
	}

	/**
	 * Render the help description of this field.
	 *
	 * @access public
	 */
	public function render_help() {
		global $qbppc;
		$field_data = $qbppc->get_form()->get_field_data();
		$original_name = str_replace('qbppc_', '', $this->get_id());
		$help = !empty($field_data[$original_name]['help']) ? $field_data[$original_name]['help'] : '';
		if (!$help) {
			return;
		}
		?>
		<p class="description"><?php echo $help; ?></p>
		<?php
	}

	/**
	 * Render the required attribute of the field.
	 *
	 * @access public
	 */
	public function render_required() {
		global $qbppc;
		$field_data = $qbppc->get_form()->get_field_data();
		$original_name = str_replace('qbppc_', '', $this->get_id());

		$required = !empty($field_data[$original_name]['required']) ? $field_data[$original_name]['required'] : false;
		
		if ($required) {
			echo ' required="required"';
		}
	}

	/**
	 * Render this field.
	 *
	 * @access public
	 * @abstract
	 */
	abstract public function render();

}