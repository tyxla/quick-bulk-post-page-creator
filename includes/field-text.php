<?php
/**
 * Manages and renders a text settings field.
 *
 * @uses QBPPC_Field
 */
class QBPPC_Field_Text extends QBPPC_Field {

	/**
	 * Render this field.
	 *
	 * @access public
	 */
	public function render() {
		?>
		<input name="<?php echo $this->get_id(); ?>" id="<?php echo $this->get_id(); ?>" type="text" value="<?php echo esc_attr($this->get_value()); ?>" class="regular-text" <?php echo $this->render_required(); ?> />
		<?php
		$this->render_help();
	}

}