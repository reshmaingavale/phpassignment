=== Add image to Post ===
Contributors: Onigetoc
Tags: image, autoblog, Post, posts
Requires at least: 2.8
Tested up to: 3.2
Stable tag: 0.6

The Add image to Post plugin allows you to insert image automatically as featured image your post from external link.

== Description ==

The Add image to Post plugin is a Wordpress plugin that allows you to insert a image to your post from external link. The plugin scan the external website to find the most revelant image and add it as a featured image associated to a post. The plugin only trigger when your articles page (single) is loaded once, after that, the image become the post featured image and create a custom field with the name "gc_thumb" and give you the full url of the new image location on your server. More infos at http://www.appsmobiledev.com/wordpress-add-image-to-post-plugin

Work well for Autoblog Wordpress blog like Autobloggeg or WPRobot.

* Add image as you write your post
* insert a image to your post from external link (Great for autoblog website)
* Scan your post content to find external link, take the most revelant image from the external website and add it to your upload folder and show it in your post or/and loop
* Work well for Autoblog Wordpress blog like Autobloggeg or WPRobot.
* Use any custom field already set in your Wordpress blog to find image from external website.

== Instruction ==

== How to add image in loop? == 
Your theme may already be set to show featured image in loop, like the home page, search and tags and may work right after instalation and setting.

== How to add featured image in loop. (index page, search page, tags search page ect.) == 

if(has_post_thumbnail()) {
	the_post_thumbnail();
}

Give size (usually, you can set thumnbail size in your Wordpress Settings => Media => Thumbnail size)

<?php if ( has_post_thumbnail() ) { 
the_post_thumbnail(array(170,140), array('class' => 'alignleft'));
} ?>

== Using Get_post_meta == 

The Add image to Post plugin automatically create a new Post Meta named: gc_thumb

if(get_post_meta($post_id, "gc_thumb", true))
			{  
			$gc_img_link = get_post_meta($post_id , "gc_thumb", true);
			echo '<img src="'.$gc_img_link.'" class="your_image_class_here" />';
			}

== Installation ==

1. Upload the Add image to Post folder to your plugins ('/wp-content/plugins/') directory.
2. Activate the plugin from your Plugins page.
3. Add image to your posts. Go to the setting page to set options.

== Frequently Asked Questions ==

= Who can I contact for support? =

Send all support questions to the author: ginocote [at] gmail.com.

== Screenshots ==

1. Add image to post setting panel
2. Image before using Add image to post
3. Image after using Add image to post
