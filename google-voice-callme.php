<?php
/*
Plugin Name: Google Voice Widget Plugin
Plugin URI: http://incredipress.com/google-voice-widget-plugin/
Description: Adds a Call Me widget ala Google Voice
Version: 0.2.2
Author: Mike Rosile, incredipress
Author URI: http://incredipress.com
*/

require_once(WP_PLUGIN_DIR . "/google-voice-plugin/widget.php");
require_once(WP_PLUGIN_DIR . "/google-voice-plugin/options.php");

register_activation_hook(__FILE__, 'gv_callme_install');
add_action('admin_menu', 'gv_callme_menu_items');
add_action('admin_print_styles', 'gv_callme_init_css');

function gv_callme_install()
{
	global $wpdb;
	
	add_option('google_voice_callme_html', '');
	add_option('google_voice_callme_dnd_html', '<img src="'.get_option('home').'/wp-content/plugins/google-voice-plugin/images/gvwidget-dnd.png" alt="" />');
	delete_option('gvwidget_html');
	delete_option('google_voice_callme_dnd_image');
}

function gv_callme_menu_items()
{
    add_options_page('Google Voice CallMe Options', 'CallMe', 8, basename(__FILE__), 'gv_callme_plugin_options');  
}

function gv_callme_init_css()
{
    wp_enqueue_style('gvwidget', '/wp-content/plugins/google-voice-plugin/css/admin.css');
}

if ( function_exists('register_uninstall_hook') )     
    register_uninstall_hook(__FILE__, 'my_uninstall_hook'); 
 
function my_uninstall_hook() 
{
    delete_option('google_voice_callme_html');
	delete_option('google_voice_callme_dnd_image');
	delete_option('google_voice_callme_dnd_html');
}

?>
