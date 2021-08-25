<?php
/**
 * @package
 */
/*
Plugin Name:discount woocommerce
Plugin URI: https://soalwp.com/
Description: By selecting a discounted product for a product in the edit section, if the user has already
purchased the selected product, a discount will be included for this product and the discounted amount will
be sent to the portal.
Version: 1.4.0
Author: مهدی قاسمی
Author URI: https://soalwp.com/
License: GPLv2
*/

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
define('DWP_PATH',plugin_dir_path(__FILE__));
define('DWP_DIR',plugin_dir_url(__FILE__));


new DWP\Course_Metabox();
new DWP\Cart();
new DWP\Enqueue();