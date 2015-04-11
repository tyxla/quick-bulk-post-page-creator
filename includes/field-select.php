<?php
/**
 * Manages and renders a select settings field.
 *
 * @uses QBPPC_Field
 */
class QBPPC_Field_Select extends QBPPC_Field {

	/**
	 * Render this field.
	 *
	 * @access public
	 */
	public function render() {
		$field_value = $this->get_value();
		?>
		<select name="<?php echo $this->get_id(); ?>" id="<?php echo $this->get_id(); ?>" class="postform">
			<?php foreach ($this->get_options() as $value => $text): ?>
				<option value="<?php echo esc_attr($value); ?>" <?php selected($field_value, $value); echo $this->render_required(); ?>><?php echo $text; ?></option>
			<?php endforeach ?>
		</select>
		<?php
		$this->render_help();
	}

	/**
	 * Retrieve the field options.
	 *
	 * @access public
	 *
	 * @return array $options The options of this field.
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Modify the options of this field.
	 *
	 * @access public
	 *
	 * @param array $options The new options.
	 */
	public function set_options($options) {
		$this->options = $options;
	}

}