<?php

namespace ORDPR\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    ORDPR
 * @subpackage ORDPR/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ORDPR
 * @subpackage ORDPR/admin
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Product {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Array of release version
	 *
	 * @since	1.0.0
	 * @var 	array
	 */
	protected $release_version = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     * Register custom product type
     * Hooked via action init, priority 10
     * @since   1.0.0
     * @return  void
     */
    public function register_post_type() {

        $labels = array(
            'name'                  => _x( 'Release Products', 'Post type general name', 'or-dpr' ),
            'singular_name'         => _x( 'Release Product', 'Post type singular name', 'or-dpr' ),
            'menu_name'             => _x( 'Release Products', 'Admin Menu text', 'or-dpr' ),
            'name_admin_bar'        => _x( 'Release Product', 'Add New on Toolbar', 'or-dpr' ),
            'add_new'               => __( 'Add New', 'or-dpr' ),
            'add_new_item'          => __( 'Add New Release Product', 'or-dpr' ),
            'new_item'              => __( 'New Release Product', 'or-dpr' ),
            'edit_item'             => __( 'Edit Release Product', 'or-dpr' ),
            'view_item'             => __( 'View Release Product', 'or-dpr' ),
            'all_items'             => __( 'All Release Products', 'or-dpr' ),
            'search_items'          => __( 'Search Release Products', 'or-dpr' ),
            'parent_item_colon'     => __( 'Parent Release Products:', 'or-dpr' ),
            'not_found'             => __( 'No release-products found.', 'or-dpr' ),
            'not_found_in_trash'    => __( 'No release-products found in Trash.', 'or-dpr' ),
            'featured_image'        => _x( 'Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'archives'              => _x( 'Release Product archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'or-dpr' ),
            'insert_into_item'      => _x( 'Insert into release-product', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'or-dpr' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this release-product', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'or-dpr' ),
            'filter_items_list'     => _x( 'Filter release-products list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'or-dpr' ),
            'items_list_navigation' => _x( 'Release Products list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'or-dpr' ),
            'items_list'            => _x( 'Release Products list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'or-dpr' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'release-product' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'show_in_nav_menus'  => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
        );

        register_post_type( ORDPR_PRODUCT_CPT, $args );

    }

    /**
     * Register custom taxonomy
     * Hooked via action init, priority 11
     * @since   1.0.0
     * @return  void
     */
    public function register_taxonomy() {

        $labels = array(
            'name'              => _x( 'Product Tags', 'taxonomy general name', 'or-dpr' ),
            'singular_name'     => _x( 'Product Tag', 'taxonomy singular name', 'or-dpr' ),
            'search_items'      => __( 'Search Product Tags', 'or-dpr' ),
            'all_items'         => __( 'All Product Tags', 'or-dpr' ),
            'parent_item'       => __( 'Parent Product Tag', 'or-dpr' ),
            'parent_item_colon' => __( 'Parent Product Tag:', 'or-dpr' ),
            'edit_item'         => __( 'Edit Product Tag', 'or-dpr' ),
            'update_item'       => __( 'Update Product Tag', 'or-dpr' ),
            'add_new_item'      => __( 'Add New Product Tag', 'or-dpr' ),
            'new_item_name'     => __( 'New Product Tag Name', 'or-dpr' ),
            'menu_name'         => __( 'Product Tag', 'or-dpr' ),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'product-tag' ),
        );

        register_taxonomy( ORDPR_PRODUCT_TAG_CT, array( ORDPR_PRODUCT_CPT ), $args );
    }

	/**
	 * Modify post table
	 * Hooked via filter manage_ordpr-product_posts_columns, priority 10
	 * @since 	1.0.0
	 * @param 	array 	$columns
	 * @return 	array
	 */
	public function modify_custom_columns( array $columns ) {

		unset($columns['date']);

		$position = 2;

		$columns = array_merge(
			array_slice($columns, 0, $position),
			array(
				'version'  => __('Version', 'or-dpr'),
				'download' => __('Download', 'or-dpr'),
			),
			array_slice($columns, $position)
		);

		return $columns;
	}

	/**
	 * Get release data
	 * @since 	1.0.0
	 * @param  	integer $post_id
	 * @return 	array
	 */
	protected function get_release_data( $post_id ) {

		if(!array_key_exists($post_id, $this->release_version)) :

			$query = new \WP_Query([
									'post_type'      => ORDPR_RELEASE_CPT,
									'post_parent'    => $post_id,
									'posts_per_page' => 1
								   ]);

			$data =  array(
				'version'	=> '-',
				'download'	=> array(
					'date'	=> array(),
					'all'	=> 0
				)
			);

			if(0 < count($query->posts)) :

				$release_version = $query->posts[0];

				$data['version']  = $release_version->post_title;
				$data['download'] = apply_filters('ordpr/release/get-download-data', array(), $release_version->ID);
			endif;

			$this->release_version[$post_id] = $data;

		endif;

		return $this->release_version[$post_id];
	}

	/**
	 * Display value based on column table
	 * Hooked via filter manage_ordpr-product_posts_custom_column, priority 10
	 * @since 	1.0.0
	 * @param  	string 	$column
	 * @param  	integer $post_id
	 * @return 	void
	 */
	public function display_column_value( $column, $post_id ) {

		$release_data = $this->get_release_data($post_id);

		switch( $column ) :

			case 'version' :
				echo '<code>' . $release_data['version'] . '</code>';
				break;

			case 'download'	:
				?>
				<div>
					<label>Total</label>
					<span><code><?= $release_data['download']['all']; ?></code></span>
				</div>
				<div>
					<label>30-day</label>
					<span><code>127</code></span>
				</div>
				<?php
				break;

		endswitch;
	}

	/**
	 * Register carbonfields
	 * Hooked via action carbon_fields_register_fields, priority 10
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function register_carbon_fields() {

		Container::make('post_meta', __('Setting', 'or-dpr'))
			->where('post_type', '=', ORDPR_PRODUCT_CPT)
			->add_fields([
				Field::make('media_gallery',	'gallery',	__('Gallery', 'or-dpr')),
			]);

	}

}
