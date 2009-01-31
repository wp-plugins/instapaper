<?php
/*
Plugin Name: Instapaper Read Later Links
Description: Automatically display Instapaper 'Read Later' links next to your blog posts.
Plugin URI:  http://lud.icro.us/wordpress-plugin-embed-instapaper/
Version:     1.0
License:     GNU General Public License
Author:      John Blackbourn
Author URI:  http://johnblackbourn.com/

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

*/

class Instapaper {

	var $plugin;

	function Instapaper() {
		add_action( 'read_later',           array( &$this, 'read_later' ) );
		add_action( 'admin_menu',           array( &$this, 'admin_menu' ) );
		add_action( 'init',                 array( &$this, 'script' ) );
		add_action( 'wp_head',              array( &$this, 'style' ) );
		add_filter( 'the_excerpt',          array( &$this, 'content' ) );
		add_filter( 'the_content',          array( &$this, 'content' ) );
		add_filter( 'ozh_adminmenu_icon',   array( &$this, 'icon' ) );
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );

		$this->plugin = array(
			'url' => '' . WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ),
			'ver' => '1.0'
		);
	}

	function admin_menu() {
		add_options_page( 'Read Later Links Settings', 'Read Later Links', 'manage_options', 'instapaper', array( &$this, 'settings' ) );
	}

	function style() {
		?>
		<style type="text/css">

		.read_later {
		<?php echo get_option( 'read_later_css' ); ?>
		}

		</style>
		<?php
	}

	function script() {
		wp_enqueue_script(
			'instapaper',
			'http://www.instapaper.com/javascript/embed.js',
			null,
			$this->plugin['ver']
		);
	}

	function code() {
		global $post;
		return '<span class="read_later"><script type="text/javascript"><!--
			instapaper_embed( "' . get_permalink( $post->ID ). '", "' . get_the_title( $post->ID ). '", "" );
		//--></script></span>';
	}

	function read_later() {
		echo $this->code();
	}

	function content( $content ) {
		if ( 'all' == get_option( 'read_later_filter' ) )
			$content = $this->code() . $content;
		if ( ( is_single() or is_page() ) and ( 'single' == get_option( 'read_later_filter' ) ) )
			$content = $this->code() . $content;
		else if ( !is_single() and !is_page() and ( 'nonsingle' == get_option( 'read_later_filter' ) ) )
			$content = $this->code() . $content;
		return $content;
	}

	function settings() {
		?>

	<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Read Later Links Settings</h2>

	<form method="post" action="options.php">
	<?php wp_nonce_field( 'update-options' ); ?>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="read_later_filter,read_later_css" />

	<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e( 'Automatic &#8216;Read Later&#8217; Link Placement', 'instapaper' ); ?></th>
		<td>
			<p><label><input type="radio" name="read_later_filter" <?php checked('all',get_option('read_later_filter')); ?> value="all" /> <?php _e( 'I&#8217;d like them everywhere!', 'instapaper' ); ?></label></p>
			<p><label><input type="radio" name="read_later_filter" <?php checked('single',get_option('read_later_filter')); ?> value="single" /> <?php _e( 'Just on single posts and pages', 'instapaper' ); ?></label></p>
			<p><label><input type="radio" name="read_later_filter" <?php checked('nonsingle',get_option('read_later_filter')); ?> value="nonsingle" /> <?php _e( 'Just on my home page and archives', 'instapaper' ); ?></label></p>
			<p><label><input type="radio" name="read_later_filter" <?php checked('false',get_option('read_later_filter')); ?> value="false" /> <?php _e( 'Don&#8217;t automatically display them at all', 'instapaper' ); ?></label><br /><span class="setting-description"><?php printf( __( 'You&#8217;ll need to add the %s template tag inside the WordPress loop in this case.', 'instapaper' ), "<code>&lt;?php do_action('read_later'); ?&gt;</code>" ); ?></span></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e( 'Custom CSS', 'instapaper' ); ?></th>
		<td>
			<p><textarea name="read_later_css" class="code" rows="4" cols="50"><?php form_option( 'read_later_css' ); ?></textarea>
			<p class="setting-description"><?php _e( 'You can specify your own CSS for the &#8216;Read Later&#8217; links here. Note that the only CSS rules that will have real effect are margins and positions as the actual link is an unstylable image inside an iframe. This CSS is applied regardless of the automatic placement setting.', 'instapaper' ); ?></p>
			</p>
		</td>
	</tr>
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>

	</div>

	<?php
	}

	function activate() {
		add_option( 'read_later_filter', 'all' );
		add_option( 'read_later_css',    "float: right;\nmargin: 5px 0px 10px 15px;" );
	}

	function icon( $hook ) {
		if ( $hook == 'instapaper' )
			return $this->plugin['url'] . '/icon.png';
		return $hook;
	}

}

if ( !defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( !defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( !defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( !defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

load_plugin_textdomain( 'instapaper', PLUGINDIR . '/' . dirname( plugin_basename( __FILE__ ) ), dirname( plugin_basename( __FILE__ ) ) ); # eugh

$instapaper = new Instapaper();

?>