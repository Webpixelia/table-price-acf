<?php

defined( 'ABSPATH' ) || exit();

/** if class `Table_Price_ACF` doesn't exists yet. */
if ( ! class_exists( 'Table_Price_ACF' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 * Main initiation class
	 *
	 * @since 1.0.0
	 */
	final class Table_Price_ACF {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;


		/**
		 * Minimum PHP version required
		 *
		 * @var string
		 */
		private static $min_php = '7.4.0';
		
		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct() {
			if ( $this->check_environment() ) {
				$this->load_files();
				add_action( 'admin_notices', [ $this, 'print_notices' ], 15 );
				add_action( 'init', [ $this, 'lang' ] );
			}
		}
		/**
		 * Ensure theme and server variable compatibility
		 *
		 * @return boolean
		 * @since  1.0.0
		 * @access private
		 */
		private function check_environment() {
			$return = true;

			/** Check the PHP version compatibility */
			if ( version_compare( PHP_VERSION, self::$min_php, '<=' ) ) {
				$return = false;

				$notice = sprintf( esc_html__( 'Unsupported PHP version Min required PHP Version: "%s"', 'table-price-acf' ), self::$min_php );
			}

			/** Add notice and deactivate the plugin if the environment is not compatible */
			if ( ! $return ) {
				add_action(
					'admin_notices', function () use ( $notice ) { ?>
                    <div class="notice is-dismissible notice-error">
                        <p><?php echo $notice; ?></p>
                    </div>
					<?php
				}
				);

				return $return;
			} else {
				return $return;
			}
		}
		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function load_files() {

			//core includes
			include_once TABLE_PRICE_ACF_INCLUDES . '/functions.php';
			include_once TABLE_PRICE_ACF_TEMPLATES . '/shortcode.php';
		}
		
		/**
		 * Initialize plugin for localization
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function lang() {
			load_plugin_textdomain( 'table-price-acf', false, dirname( plugin_basename( TABLE_PRICE_ACF_FILE ) ) . '/languages/' );
		}
		
		/**
		 * Print the admin notices
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_notices() {
			if ( ! class_exists( 'ACF' ) ) {
				$link    = esc_url(
					add_query_arg(
						array(
							'tab'       => 'plugin-information',
							'plugin'    => 'advanced-custom-fields',
							'TB_iframe' => 'true',
							'width'     => '640',
							'height'    => '500',
						),
						admin_url( 'plugin-install.php' )
					)
				);
				$outline = '<div class="error"><p>' . sprintf( wp_kses_post( __( 'You must install and activate <a class="thickbox open-plugin-details-modal" href="%s"><strong>ACF Pro</strong></a> plugin to make the <strong>Table Price ACF</strong> work.', 'table-price-acf' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $link ) ) . '</p></div>';
				echo wp_kses_post( $outline );
				deactivate_plugins(plugin_basename( TABLE_PRICE_ACF_FILE ));
			}
		}

		/**
		 * Main Table_Price_ACF Instance.
		 *
		 * Ensures only one instance of Table_Price_ACF is loaded or can be loaded.
		 *
		 * @return Table_Price_ACF - Main instance.
		 * @since 1.0.0
		 * @static
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

}

/** if function `table_price_wp` doesn't exists yet. */
if ( ! function_exists( 'table_price_wp' ) ) {
	function table_price_wp() {
		return Table_Price_ACF::instance();
	}
}

/** fire off the plugin */
table_price_wp();
