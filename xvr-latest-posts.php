<?php

/**
 * Plugin Name:       XVR Latest Posts
 * Plugin URI:        https://zabiranik.me
 * Description:       Dashboard widget plugin for latest posts
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zabir Anik
 * Author URI:        https://zabiranik.me
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       xvr-latest-posts
 */

use XVR\Latest_Post\Admin_Handler;
use XVR\Latest_Post\Installer;

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main plugin class
 */
final class XVR_Latest_Post {

    /**
     * Plugin Version
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class Constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * Initializes a Singleton
     * @return \XVR_Latest_Post
     */
    public static function init() {

        static $instance = false;

        if ( ! $instance ) {
            $instance = new Self();
        }

        return $instance;
    }

    /**
     * Defines plugin constants
     * @return void
     */
    public function define_constants() {
        define( 'XVR_LATEST_POST_VERSION', self::version );
    }

    /**
     * Plugin init
     * @return void
     */
    public function init_plugin() {
        if ( is_admin() ) {
            new Admin_Handler;
        }
    }

    /**
     * Executes on plugin activation
     * @return void
     */
    public function activate() {
        $installer = new Installer;
        $installer->run();
    }

    /**
     * Enqueues styles/scripts
     *
     * @return void
     */
    public function enqueue() {
        wp_enqueue_style('xvr-latest-posts-style', plugins_url('/assets/css/main.css', __FILE__));
    }
}

/**
 * Plugin Instance init
 * @return \XVR_Latest_Post
 */
function xvr_latest_post_init()
{
    return XVR_Latest_Post::init();
}

// Initialize the plugin
xvr_latest_post_init();