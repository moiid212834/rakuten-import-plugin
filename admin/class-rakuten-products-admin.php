<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://linkedin.com/in/devmoeed
 * @since      1.0.0
 *
 * @package    Rakuten_Products
 * @subpackage Rakuten_Products/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rakuten_Products
 * @subpackage Rakuten_Products/admin
 * @author     Moeed Ahmad <moeed27@gmail.com>
 */
class Rakuten_Products_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name='rakuten-products';

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version='1.0.0';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

	
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rakuten_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rakuten_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rakuten-products-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rakuten_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rakuten_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rakuten-products-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function create_product($product){

		$post = array(
		    'post_author' => wp_get_current_user()->ID,
		    'post_content' => $product->DESCRIPCION,
		    'post_excrept' => $product->DESCRIPCION,
		    'post_status' => "publish",
		    'post_title' => $product->NOMBRE,
		    'post_parent' => '',
		    'post_type' => "product",
		);

		// Create post
		try{
			if(!$this->sku_exists($product->EAN )){
				$post_id = wp_insert_post( $post );
				var_dump($post_id);
			}
		}catch (Throwable $e){
			echo $e->getMessage();
		}
		
		echo $post_id."created";

		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock');
		update_post_meta( $post_id, 'total_sales', '0');
		update_post_meta( $post_id, '_price', $product->PRECIO );
		update_post_meta( $post_id, '_manage_stock', "no" );
		update_post_meta( $post_id, '_backorders', "no" );
		update_post_meta( $post_id, '_sku', $product->EAN );
		
		
		wp_set_object_terms( $post_id, $product->CATEGORIA, 'product_cat' );
		$image_url=$product->IMAGENES->{'ID-0'}->nombre;
		
		try{
		$this->Generate_Featured_Image( $image_url, $post_id );}
		catch (Throwable $t){
			echo $t->getMessage();
		}
	}

	public function create_draft_product($product){


		$post = array(
		    'post_author' => wp_get_current_user()->ID,
		    'post_content' => $product->DESCRIPCION,
		    'post_excrept' => $product->DESCRIPCION,
		    'post_status' => "draft",
		    'post_title' => $product->NOMBRE,
		    'post_parent' => '',
		    'post_type' => "product",
		);

		// Create post
		try{
			if(!$this->sku_exists($product->EAN )){
				$post_id = wp_insert_post( $post );
				var_dump($post_id);
			}
		}catch (Throwable $e){
			echo $e->getMessage();
		}
		
		echo $post_id."created";

		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock');
		update_post_meta( $post_id, 'total_sales', '0');
		update_post_meta( $post_id, '_price', $product->PRECIO );
		update_post_meta( $post_id, '_manage_stock', "no" );
		update_post_meta( $post_id, '_backorders', "no" );
		update_post_meta( $post_id, '_sku', $product->EAN );
		
		wp_set_object_terms( $post_id, $product->CATEGORIA, 'product_cat' );
		$image_url=$product->IMAGENES->{'ID-0'}->nombre;
		
		try{
		$this->Generate_Featured_Image( $image_url, $post_id );}
		catch (Throwable $t){
			echo $t->getMessage();
		}
	}

	private function Generate_Featured_Image( $image_url, $post_id  ){
	    $upload_dir = wp_upload_dir();
	    $image_data = file_get_contents($image_url);
	    $filename = basename($image_url);
	    if(wp_mkdir_p($upload_dir['path']))
	      $file = $upload_dir['path'] . '/' . $filename;
	    else
	      $file = $upload_dir['basedir'] . '/' . $filename;
	    file_put_contents($file, $image_data);

	    $wp_filetype = wp_check_filetype($filename, null );
	    $attachment = array(
	        'post_mime_type' => $wp_filetype['type'],
	        'post_title' => sanitize_file_name($filename),
	        'post_content' => '',
	        'post_status' => 'inherit'
	    );
	    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	    $res2= set_post_thumbnail( $post_id, $attach_id );
	}

	public function add_all_products($products){

		foreach ($products as $key => $product) {
			
			$this->create_product(json_decode($product));
		}
	}

	public function draft_all_products($products){

		foreach ($products as $key => $product) {
			var_dump($product);
			$this->create_draft_product(json_decode(stripslashes($product)));
		}
	}

	public function show_view(){

		include 'views/add-products.php';
	}

	public function update_options($options){
		file_put_contents('options.json', $options);
	}
	public function get_options(){
		return   json_decode(file_get_contents('options.json'));
	}

	public function sku_exists($sku){
	  global $wpdb;

	  $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

	  if ( $product_id ) return true;

	  return false;
	}

}

