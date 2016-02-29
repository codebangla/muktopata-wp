<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', '_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), 'v3.3.5', true );
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Bootstrap integration
*/
require get_template_directory() . '/inc/functions-strap.php';


/****************Custom Post Type******************
 ***********@author: Md. Sajedul Haque Romi********
 *************************************************/

/*****************Product Custom Post Type starts********************/

function my_custom_post_product() {
	$labels = array(
		'name'               => _x( 'Products', 'post type general name' ),
		'singular_name'      => _x( 'Product', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Product' ),
		'edit_item'          => __( 'Edit Product' ),
		'new_item'           => __( 'New Product' ),
		'all_items'          => __( 'All Products' ),
		'view_item'          => __( 'View Product' ),
		'search_items'       => __( 'Search Products' ),
		'not_found'          => __( 'No products found' ),
		'not_found_in_trash' => __( 'No products found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Products'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our products and product specific data',
		'public'        => true,
		'menu_position' => 5,
		'show_in_rest'       => true,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
		'menu_icon'           => 'dashicons-cart',
	);
	register_post_type( 'product', $args );
}
add_action( 'init', 'my_custom_post_product' );

/*****************Product Custom Post Type ends********************/


function my_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['product'] = array(
		0 => '',
		1 => sprintf( __('Product updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Product updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Product published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Product saved.'),
		8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );


function my_contextual_help( $contextual_help, $screen_id, $screen ) {
	if ( 'product' == $screen->id ) {

		$contextual_help = '<h2>Products</h2>
    <p>Products show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
    <p>You can view/edit the details of each product by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-product' == $screen->id ) {

		$contextual_help = '<h2>Editing products</h2>
    <p>This page allows you to view/modify product details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the product description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'my_contextual_help', 10, 3 );

/*****************Product Category Taxonomy starts********************/

function my_taxonomies_product() {
	$labels = array(
		'name'              => _x( 'Product Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Product Categories' ),
		'all_items'         => __( 'All Product Categories' ),
		'parent_item'       => __( 'Parent Product Category' ),
		'parent_item_colon' => __( 'Parent Product Category:' ),
		'edit_item'         => __( 'Edit Product Category' ),
		'update_item'       => __( 'Update Product Category' ),
		'add_new_item'      => __( 'Add New Product Category' ),
		'new_item_name'     => __( 'New Product Category' ),
		'menu_name'         => __( 'Product Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );


/*****************Product Category Taxonomy ends********************/

/*****************MetaBox starts********************/
add_action( 'add_meta_boxes', 'product_price_box' );
function product_price_box() {
	add_meta_box(
		'product_price_box',
		__( 'Product Price', 'myplugin_textdomain' ),
		'product_price_box_content',
		'product',
		'side',
		'high'
	);
}

function product_price_box_content( $post ) {
	global $post;
if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
$custom = get_post_custom($post->ID);
$link = $custom["product_price"][0];
	$link2 = $custom["product_qty"][0];
wp_nonce_field( plugin_basename( __FILE__ ), 'product_price_box_content_nonce' );
	echo '<label for="product_price"></label>';
	echo '<input type="text" id="product_price" name="product_price" placeholder="enter a price"  value=" '.$link . ' " />';
	echo '<label for="product_qty"></label>';
	echo '<input type="text" id="product_qty" name="product_qty" placeholder="enter a size/weight (eg: 1pc/150gm)" value=" '.$link2 . ' " />';

}
add_action( 'save_post', 'product_price_box_save' );

function product_price_box_save( $post_id )
{

	global $post;
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

	// if our nonce isn't there, or we can't verify it, bail
	//if( !isset( $_POST['product_price_box_content_nonce'] ) || !wp_verify_nonce( $_POST['product_price_box_content_nonce'], 'product_price_box_content_nonce' ) ) return;
	//if( !isset( $_POST['product_qty_box_content_nonce'] ) || !wp_verify_nonce( $_POST['product_qty_box_content_nonce'], 'product_qty_box_content_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	// Make sure your data is set before trying to save it
	if( isset( $_POST['product_price'] ) )
		update_post_meta( $post->ID, 'product_price', wp_kses( $_POST['product_price'], $allowed ) );
	if( isset( $_POST['product_qty'] ) )
		update_post_meta( $post->ID, 'product_qty', wp_kses( $_POST['product_qty'], $allowed ) );


}



function save_custom_details( $post_id ) {
	global $post;
	//skip auto save
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	//check for you post type only
	if( $post->post_type == "product" ) {
		if( isset($_POST['product_price']) ) { update_post_meta( $post->ID, 'product_price', $_POST['product_price'] );}
		//if( isset($_POST['ingredients']) ) { update_post_meta( $post->ID, 'ingredients', $_POST['ingredients'] );}

	}
}


// support for REST API

add_action( 'rest_api_init', 'add_location_to_career_endpoint' );
function add_location_to_career_endpoint() {
	register_rest_field( 'product',
		'product_price',
		array(
			'get_callback'    => 'product_get_price',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field( 'product',
		'product_qty',
		array(
			'get_callback'    => 'product_get_qty',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
function product_get_price( $object, $field_name, $request ) {
	//return get_the_terms( $object[ 'product_price' ], $taxonomies, null);
    return  get_post_meta( $object[ 'id' ], 'product_price', true );
}

function product_get_qty( $object, $field_name, $request ) {
	//return get_the_terms( $object[ 'product_price' ], $taxonomies, null);
	return  get_post_meta( $object[ 'id' ], 'product_qty', true );
}


/*****************MetaBox ends********************/




add_image_size( 'product-img-home', 320, 200 );

function product_thumbnail_url($pid){
	$image_id = get_post_thumbnail_id($pid);
	$image_url = wp_get_attachment_image_src($image_id, 'product-img-home');
	return  $image_url[0];
}