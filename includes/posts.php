<?php
/**
 * Handles functionality, related to posts.
 */
class QBPPC_Posts {

	/**
	 * Retrieve the available post types.
	 *
	 * @access public
	 * @static
	 *
	 * @param array $post_types Retrieve the available post types.
	 */
	public static function get_post_types() {
		$post_types = array();

		$all_post_types = get_post_types(array(), 'objects');
		foreach ($all_post_types as $post_type_name => $post_type_object) {
			$post_types[$post_type_name] = $post_type_object->labels->name;
		}

		return $post_types;
	}

}