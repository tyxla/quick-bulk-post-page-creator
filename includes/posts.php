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
	 * @return array $post_types Retrieve the available post types.
	 */
	public static function get_post_types() {
		$post_types = array();

		$all_post_types = get_post_types(array(), 'objects');
		foreach ($all_post_types as $post_type_name => $post_type_object) {
			$post_types[$post_type_name] = $post_type_object->labels->name;
		}

		return $post_types;
	}

	/**
	 * Using an array hierarchy, insert the entries hierarchy.
	 *
	 * @access public
	 * @static
	 *
	 * @param array $hierarchy Hierarchy of entries to insert.
	 * @param string $post_type Post type of the entries.
	 * @param string $post_status Post status of the entries.
	 * @param int $parent ID of the parent entry.
	 * @return int $total Number of entries that were inserted.
	 */
	public static function process_hierarchy($hierarchy = array(), $post_type = 'post', $post_status = 'publish', $parent = 0) {

        global $wpdb;

		$total = 0;
		$menu_order_max = $wpdb->get_var("SELECT MAX(menu_order)+1 AS menu_order FROM {$wpdb->posts} WHERE post_type='{$post_type}'");

		foreach ($hierarchy as $hierarchy_entry) {
			$menu_order = $menu_order_max + $total;
			$id = self::insert($post_type, $hierarchy_entry['title'], $post_status, $parent, $menu_order);
			$total++;

			if ( !empty($hierarchy_entry['children']) ) {
				$total += self::process_hierarchy($hierarchy_entry['children'], $post_type, $post_status, $id);
			}
		}

		return $total;
	}

	/**
	 * Insert a post of certain post type with a certain title under a specific parent.
	 *
	 * @access public
	 * @static
	 *
	 * @param string $post_type Post type of the post.
	 * @param string $title Title of the post.
	 * @param string $post_status Post status of the post.
	 * @param int $parent ID of the parent post.
	 * @param int $menu_order Menu order of the post.
	 * @return int $id The ID of the inserted post.
	 */
	public static function insert($post_type, $title, $post_status = 'publish', $parent = 0, $menu_order = 0) {
		$args = array(
			'post_type' => $post_type,
			'post_title' => $title,
			'post_content' => '',
			'post_parent' => $parent,
			'post_status' => $post_status,
		);
		
		if($menu_order !== 0){
			$args['menu_order'] = $menu_order;
		}

		$id = wp_insert_post($args);

		return $id;
	}

}