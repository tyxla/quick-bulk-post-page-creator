<?php
/**
 * Hierarchy parser & builder class.
 */
class QBPPC_Hierarchy {

	/**
	 * Character for specifying hierarchy indentation 
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $character = '*';

	/**
	 * Raw multiline text to parse
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $text = '';

	/**
	 * The (parsed and built) hierarchy
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected $hierarchy = array();

	/**
	 * Parse, build and save the hierarchy.
	 *
	 * @access public
	 */
	public function build() {
		$this->parse();
		$this->set_hierarchy( $this->treeify() );
	}

	/**
	 * Use the parsed hierarchy to build a tree-like hierarchy.
	 *
	 * @access protected
	 *
	 * @param array $items The set of items before treeifying.
	 * @param string $parent The title of the parent item.
	 * @return array $branch The treeified hierarchy of items.
	 */
	protected function treeify($items = array(), $parent = '') {
		// if items not set, use the current hierarchy
		if (!$items) {
			$items = $this->get_hierarchy();
		}

		// this is where we preserve the tree
	    $branch = array();

	    // recursively build the tree hierarchy
	    foreach ($items as $item) {
	        if ($item['parent'] == $parent) {
	            $children = $this->treeify($items, $item['title']);
	            if ($children) {
	                $item['children'] = $children;
	            }
	            $branch[] = $item;
	        }
	    }

	    return $branch;
	}

	/**
	 * Parse the raw text and parse to hierarchy.
	 *
	 * @access protected
	 *
	 * @return array $hierarchy The parsed hierarchy of items.
	 */
	protected function parse() {
		$hierarchy = array();

		// split raw text by newline
		$items = explode("\n", $this->get_text());

		// trim each item
		$items = array_map('trim', $items);

		// remove empty items
		$items = array_filter($items);

		// get the hierarchy indentation character
		$character = preg_quote($this->get_character());

		// last items by depth
		$last_items = array();

		// parse each item
		foreach ($items as $key => $title) {
			// get item depth
			$depth = preg_match_all('/' . $character . '/', $title, $matches);

			// remove hierachy indentation characters
			$title = preg_replace('/' . $character . '/', '', $title);

			// determine parent
			if ( $depth && isset( $last_items[$depth - 1] ) ) {
				$parent = $last_items[$depth - 1];
			} else {
				$parent = '';
			}

			// build & add parsed hierarchy item
			$hierarchy_item = array(
				'parent' => $parent,
				'depth' => $depth,
				'title' => $title,
			);
			$hierarchy[] = $hierarchy_item;

			// preserve the last item of this depth
			$last_items[$depth] = $title;
		}

		$this->set_hierarchy($hierarchy);
	}

	/**
	 * Retrieve the character.
	 *
	 * @access public
	 *
	 * @return string $character The character.
	 */
	public function get_character() {
		return $this->character;
	}

	/**
	 * Modify the character.
	 *
	 * @access public
	 *
	 * @param string $character The new character.
	 */
	public function set_character($character) {
		$this->character = $character;
	}

	/**
	 * Retrieve the raw text.
	 *
	 * @access public
	 *
	 * @return string $text The raw text.
	 */
	public function get_text() {
		return $this->text;
	}

	/**
	 * Modify the raw text.
	 *
	 * @access public
	 *
	 * @param string $text The new raw text.
	 */
	public function set_text($text) {
		$this->text = $text;
	}

	/**
	 * Retrieve the parsed and built hierarchy.
	 *
	 * @access public
	 *
	 * @return string $hierarchy The parsed and built hierarchy.
	 */
	public function get_hierarchy() {
		return $this->hierarchy;
	}

	/**
	 * Modify the parsed and built hierarchy.
	 *
	 * @access public
	 *
	 * @param string $hierarchy The new parsed and built hierarchy.
	 */
	public function set_hierarchy($hierarchy) {
		$this->hierarchy = $hierarchy;
	}

}