<?php
/*
Plugin Name: Maxio YouTubeR Free
Plugin URI: http://youtuber.maxiolab.com/
Description: This plugin allows you to <strong>upload</strong> your videos on YouTube from your website and embed YouTube videos to your website.
Author: Maxio lab.
Version: 1.0.5 
-Author URI: http://
*/
defined('ABSPATH') or die(':)');

define('MXYOUTUBER_VERSION','1.0.5');
define('MXYOUTUBER_PATH',plugin_dir_path( __FILE__ ));
define('MXYOUTUBER_URL',plugin_dir_url(__FILE__));

require_once(MXYOUTUBER_PATH.'functions.php');
require_once(MXYOUTUBER_PATH.'data.php');
require_once(MXYOUTUBER_PATH.'views/base.php');


add_shortcode('mx_youtuber', 'mxYoutubeR_renderShortCode');
add_action('media_buttons','mxYoutubeR_button',99);
add_action('admin_menu', function(){add_submenu_page(
	'options-general.php', 
	'YouTubeR Free', 
	'YouTubeR Free', 
	'administrator', 
	'mx-youtuber', 
	'mxYoutubeR_renderSettingsPage'
);} );
add_action( 'wp_enqueue_scripts', 'mxYoutubeR_frontend' );
add_action( 'admin_enqueue_scripts', 'mxYoutubeR_backend' );
add_action('admin_head', 'mxYoutubeR_backendInline');

add_action('plugins_loaded', 'mxYoutubeR_pluginsLoaded' );

