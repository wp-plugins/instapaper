=== Instapaper Read Later Links ===
Contributors: johnbillion
Tags: instapaper, bookmark, tumblr, read later, social bookmarking
Donate link: http://lud.icro.us/donations/
Requires at least: 2.3
Tested up to: 2.9.9
Stable tag: trunk

Allows you to automatically display Instapaper 'Read Later' links next to your blog posts.

== Description ==

This plugin allows you to display Instapaper 'Read later' links next to each post on your blog just like on [Give Me Something To Read](http://givemesomethingtoread.com/). You can either automatically insert the links adjacent to your blog entries, or you can just use the template tag to insert the links wherever you like.

== Installation ==

1. Unzip the ZIP file and drop the folder straight into your `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Check out the front page of your blog. A 'Read Later' link will now show adjacent to each post.

= Usage =

By default, this plugin adds a 'Read Later' link adjacent to each blog entry on your blog. If you wish to control where the links are displayed, you can go to the Settings -> Read Later Links menu and disable the automatic links.

If you do this, you'll then need to add the following code to your theme in order insert a 'Read Later' link for each post:

`<php do_action('read_later'); ?>`

The code must be inside the WordPress loop.

== Screenshots ==

1. 'Read Later' links inserted automatically into the WordPress default theme

2. 'Read Later' links shown on [Ludicrous](http://lud.icro.us/) using the template tag to control placement

3. The options screen

== Frequently Asked Questions ==

= What the hell is Instapaper? =

From instapaper.com:

> Instapaper is a fast, easy, free tool to save web pages for reading later. When you find something you want to read, but you don't have time now, you click 'Read Later'. When you do have time to read, you visit Instapaper on your computer or phone and get whatever you wanted to read. 

Check out [instapaper.com](http://instapaper.com/) for all the details and to sign up.

= Is this an official Instapaper plugin? =

No.

== Changelog ==

= 1.0 =
* Initial release.
