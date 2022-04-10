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
class Release {

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
	 * Get product as options
	 * @since 	1.0.0
	 * @return 	array
	 */
	public function get_product_options() {

		$options = array(
			''	=> __('No product', 'or-dpr')
		);

		$query = new \WP_Query(array(
			'post_type'      => ORDPR_PRODUCT_CPT,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC'
		));

		foreach($query->posts as $post) :
			$options[$post->ID] = $post->post_title . ' #'.$post->ID;
		endforeach;

		return $options;
	}

    /**
     * Register custom version type
     * Hooked via action init, priority 10
     * @since   1.0.0
     * @return  void
     */
    public function register_post_type() {

        $labels = array(
            'name'                  => _x( 'Release Versions', 'Post type general name', 'or-dpr' ),
            'singular_name'         => _x( 'Release Version', 'Post type singular name', 'or-dpr' ),
            'menu_name'             => _x( 'Release Versions', 'Admin Menu text', 'or-dpr' ),
            'name_admin_bar'        => _x( 'Release Version', 'Add New on Toolbar', 'or-dpr' ),
            'add_new'               => __( 'Add New', 'or-dpr' ),
            'add_new_item'          => __( 'Add New Release Version', 'or-dpr' ),
            'new_item'              => __( 'New Release Version', 'or-dpr' ),
            'edit_item'             => __( 'Edit Release Version', 'or-dpr' ),
            'view_item'             => __( 'View Release Version', 'or-dpr' ),
            'all_items'             => __( 'All Release Versions', 'or-dpr' ),
            'search_items'          => __( 'Search Release Versions', 'or-dpr' ),
            'parent_item_colon'     => __( 'Parent Release Versions:', 'or-dpr' ),
            'not_found'             => __( 'No release-versions found.', 'or-dpr' ),
            'not_found_in_trash'    => __( 'No release-versions found in Trash.', 'or-dpr' ),
            'featured_image'        => _x( 'Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'or-dpr' ),
            'archives'              => _x( 'Release Version archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'or-dpr' ),
            'insert_into_item'      => _x( 'Insert into release-version', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'or-dpr' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this release-version', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'or-dpr' ),
            'filter_items_list'     => _x( 'Filter release-versions list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'or-dpr' ),
            'items_list_navigation' => _x( 'Release Versions list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'or-dpr' ),
            'items_list'            => _x( 'Release Versions list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'or-dpr' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => false,
			'exclude_form_search'=> true,
            'show_ui'            => true,
            'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'release-version' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor' ),
        );

        register_post_type( ORDPR_RELEASE_CPT, $args );

    }

	/**
	 * Register carbonfields
	 * Hooked via action carbon_fields_register_fields, priority 10
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function register_carbon_fields() {

		Container::make('post_meta', __('Setting', 'or-dpr'))
			->where('post_type', '=', ORDPR_RELEASE_CPT)
			->add_fields([
				Field::make('select',	'product',			__('Product', 'or-dpr'))
					->add_options(array($this, 'get_product_options'))
					->set_required(true),

				Field::make('date',		'release_date',		__('Release Date', 'or-dpr'))
					->set_required(true),

				Field::make('file', 	'download_file', 	__('File', 'or-dpr'))
					->set_required(true),

				Field::make('media_gallery',	'gallery',	__('Gallery', 'or-dpr')),
			]);

	}

	/**
	 * Set parent page
	 * Hooked via filter wp_inser_post_data, priority 10
	 * @since 	1.0.0
	 * @param 	array $data
	 * @param 	array $post_args
	 * @return 	array
	 */
	public function set_parent_page( array $data, array $post_args) {

		global $post;

		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $data;

		if(
			ORDPR_RELEASE_CPT === $post->post_type &&
			isset($_POST['carbon_fields_compact_input']) &&
			isset($_POST['carbon_fields_compact_input']['_product'])
		) :

			$product_id          = absint($_POST['carbon_fields_compact_input']['_product']);
			$data['post_parent'] = $product_id;

		endif;

		return $data;
	}

	/**
	 * Get download release data
	 * Hooked via filter ordpr/release/get-download-data, priority 99
	 * @since 	1.0.0
	 * @param  	int|WP_Post 	$release
	 * @return 	array
	 */
	public function get_download_data( $download = array(), $release ) {

		$download =  array(
			'date'	=> array(),
			'all'	=> 0
		);

		if(!is_a($release, 'WP_Post')) :

			$release = get_post($release);

		endif;

		$download = wp_parse_args(
						(array) get_post_meta( $release->ID, 'download_statistic', true),
						$download
					);

		return $download;
	}
}
