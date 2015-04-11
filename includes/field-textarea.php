<?php
/**
 * Manages and renders a textarea settings field.
 *
 * @uses QBPPC_Field
 */
class QBPPC_Field_Textarea extends QBPPC_Field {

	/**
	 * Render this field.
	 *
	 * @access public
	 */
	public function render() {
		?>
		<textarea name="<?php echo $this->get_id(); ?>" id="<?php echo $this->get_id(); ?>" class="large-text" rows="20" <?php echo $this->render_required(); ?>><?php echo esc_html($this->get_value()); ?></textarea>
		<?php
		$this->render_help();
	}

}