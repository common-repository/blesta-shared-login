<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Blesta_Shared_Login_Taxonomy {

	/**
	 * The name for the taxonomy.
	 * @var 	string
	 * @access  public
	 * @since 	1.0.0
	 */
	public $taxonomy;

	/**
	 * The plural name for the taxonomy terms.
	 * @var 	string
	 * @access  public
	 * @since 	1.0.0
	 */
	public $plural;

	/**
	 * The singular name for the taxonomy terms.
	 * @var 	string
	 * @access  public
	 * @since 	1.0.0
	 */
	public $single;

	/**
	 * The array of post types to which this taxonomy applies.
	 * @var 	array
	 * @access  public
	 * @since 	1.0.0
	 */
	public $post_types;

	public function __construct ( $taxonomy = '', $plural = '', $single = '', $post_types = array() ) {

		if( ! $taxonomy || ! $plural || ! $single ) return;

		// Post type name and labels
		$this->taxonomy = $taxonomy;
		$this->plural = $plural;
		$this->single = $single;
		if( ! is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}
		$this->post_types = $post_types;

		// Register taxonomy
		add_action('init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Register new taxonomy
	 * @return void
	 */
	public function register_taxonomy () {

        $labels = array(
            'name' => $this->plural,
            'singular_name' => $this->single,
            'menu_name' => $this->plural,
            'all_items' => sprintf( 'All %s', $this->plural ),
            'edit_item' => sprintf( 'Edit %s', $this->single ),
            'view_item' => sprintf( 'View %s', $this->single ),
            'update_item' => sprintf( 'Update %s', $this->single ),
            'add_new_item' => sprintf( 'Add New %s', $this->single ),
            'new_item_name' => sprintf( 'New %s Name', $this->single ),
            'parent_item' => sprintf( 'Parent %s', $this->single ),
            'parent_item_colon' => sprintf( 'Parent %s:', $this->single ),
            'search_items' =>  sprintf( 'Search %s', $this->plural ),
            'popular_items' =>  sprintf( 'Popular %s', $this->plural ),
            'separate_items_with_commas' =>  sprintf( 'Separate %s with commas', $this->plural ),
            'add_or_remove_items' =>  sprintf( 'Add or remove %s', $this->plural ),
            'choose_from_most_used' =>  sprintf( 'Choose from the most used %s', $this->plural ),
            'not_found' =>  sprintf( 'No %s found', $this->plural ),
        );

        $args = array(
        	'label' => $this->plural,
        	'labels' => apply_filters( $this->taxonomy . '_labels', $labels ),
        	'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'meta_box_cb' => null,
            'show_admin_column' => true,
            'update_count_callback' => '',
            'query_var' => $this->taxonomy,
            'rewrite' => true,
            'sort' => '',
        );

        register_taxonomy( $this->taxonomy, $this->post_types, apply_filters( $this->taxonomy . '_register_args', $args, $this->taxonomy, $this->post_types ) );
    }

}
