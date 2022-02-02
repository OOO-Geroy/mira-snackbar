<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/public
 * @author     Your Name <email@example.com>
 */
class Mira_Snackbar_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mira_Snackbar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mira_Snackbar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mira-snackbar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mira_Snackbar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mira_Snackbar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . 'public-js', plugin_dir_url( __FILE__ ) . 'js/mira-snackbar-public.js', array( 'jquery' ), $this->version, true );

		wp_localize_script( $this->plugin_name . 'public-js', 'mira_snackbar_settings', array(
			'rest_api' => [
				'base' => esc_url_raw( rest_url() . MIRA_SNACKBAR_REST_URL ),
				'get_snackbars' => Mira_Snacbar_Rset_API::get_route(),
			],
			'nonce' => wp_create_nonce( 'wp_rest' )
		) );

	}

}
