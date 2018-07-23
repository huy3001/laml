<?php
/*
Plugin Name: Ninja Tables Pro
Description: The Pro version of Ninja Tables, best Responsive Table Plugin for WordPress.
Version: 2.2.1
Author: WPManageNinja
Author URI: https://wpmanageninja.com/
Plugin URI: https://wpmanageninja.com/downloads/ninja-tables-pro-add-on/
License: GPLv2 or later
Text Domain: ninja-tables-pro
Domain Path: /resources/languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// To check if pro is available in scripts in this plugin
defined( 'NINJATABLESPRO' ) or define( 'NINJATABLESPRO', true );
define('NINJAPROPLUGIN_PATH',  plugin_dir_path(__FILE__));
defined('NINJAPROPLUGIN_VERSION') or define('NINJAPROPLUGIN_VERSION', '2.2.1');

define('NINJATABLESPRO_SORTABLE', true);

include 'src/Permission.php';
include 'src/Sortable.php';
include 'src/Position.php';
include 'src/libs/updater/ninja_table_pro_updater.php';

if ( ! class_exists( 'NinjaTablesPro' ) ) {
	class NinjaTablesPro {
		public function boot() {
			if(is_admin()) {
				$this->adminHooks();
			}
			$this->public_hooks();
		}
		
		/**
		 * Register admin/backend hooks
		 */
		public function adminHooks() {
			if ( current_user_can( 'install_plugins' ) ) {
				$this->checkForPluginInstall();
			}
			
			add_filter('ninja_table_admin_role', '\NinjaTablesPro\Permission::modifyPermission');
			add_filter('ninja_tables_item_attributes', '\NinjaTablesPro\Position::make');

			if ( function_exists( 'ninja_table_admin_role' ) && current_user_can( ninja_table_admin_role() ) ) {
				add_action( 'wp_ajax_ninja_tables_get_permission', '\NinjaTablesPro\Permission::get' );
				add_action( 'wp_ajax_ninja_tables_set_permission', '\NinjaTablesPro\Permission::set' );

				// Init sortable for the table.
				add_action('wp_ajax_ninja_tables_init_sortable', '\NinjaTablesPro\Sortable::init');
				add_action('wp_ajax_ninja_tables_sort_table', '\NinjaTablesPro\Sortable::sort');
			}
		}
		
		public function public_hooks() {
			add_filter('ninja_table_js_config', function ($config, $filter) {
				$config['default_filter'] = $filter;
				return $config;
			}, 10, 2);
			
			add_filter('ninja_table_column_attributes', function ($column) {
				if(isset($column['title'])) {
					$column['title'] = do_shortcode($column['title']);
				}
				return $column;
			});
		}

		
		private function checkForPluginInstall() {
			if( defined( 'NINJA_TABLES_DIR_URL' ) ) {
				return;
			}
			
			// parent plugin is not installed;
			add_action( 'admin_notices', function () {
				$pluginInfo = $this->getNinjaTableInstallDetails();

				$class = 'notice notice-error';
				
				$install_url_text = 'Click Here to Install the plugin';
				
				if($pluginInfo->action == 'activate') {
					$install_url_text = 'Click Here to Activate the plugin';
				}
				
				$message =  'NinjaTables Pro Add-On Requires Ninja Tables Base Plugin, <b><a href="'.$pluginInfo->url.'">'.$install_url_text.'</a></b>';

				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),  $message  );
				
				//print_r($pluginInfo);
			} );

		}
		
		private function getNinjaTableInstallDetails() {
			$activation = (object) array(
				'action'       => 'install',
				'url'          => ''
			);
			
			$allPlugins = get_plugins();
			if ( isset( $allPlugins['ninja-tables/ninja-tables.php'] ) ) {
				$url                = wp_nonce_url(
					self_admin_url( 'plugins.php?action=activate&plugin=ninja-tables/ninja-tables.php' ),
					'activate-plugin_ninja-tables/ninja-tables.php'
				);
				$activation->action = 'activate';
			} else {
				$api = (object) array(
					'slug' => 'ninja-tables'
				);
				$url = wp_nonce_url( 
					self_admin_url( 'update.php?action=install-plugin&plugin=' . $api->slug ),
					'install-plugin_' . $api->slug 
				);
			}
			$activation->url = $url;
			return $activation;
		}
	}

	/**
	 * Plugin init hook
	 */
	add_action( 'plugins_loaded', function () {
		$ninjaTableBoot = new \NinjaTablesPro();
		$ninjaTableBoot->boot();
	});
}