=== Flexible Recent Posts ===
Contributors: TheSteelRat
Donate link: https://flattr.com/thing/646464
Tags: recent, post, posts, widget, template, flexible, universal
Requires at least: 3.0
Tested up to: 3.3.2
Stable tag: 0.3

Displays recent posts using flexible template system. Define template for each post entry, set needed categories and much more.

== Description ==

Flexible Recent Posts (FRP) plugin gives you possibility to add widget to your blog with recent posts using user-defined template.

**The main features are:**

* **Template** for each post in widget. You can write your HTML-template or overwrite default in widget form.
* **Shortcodes** support in template. You can use built-in shortcodes to insert info related to current post in widget: `title`, `featured image`, `excerpt`, `date`, `permalink`.
* **Restrict categories** from which you want to display posts. Display posts from all categories or from selected only.
* **Number of posts** to display. Set number of latest posts that will be displayed in widget.
* **All posts links**. Select option to display link near the title or/and after all posts that will open selected posts category page. Set link title or custom link URL.

**Useful links:**

* [Template shortcodes](http://wordpress.org/extend/plugins/flexible-recent-posts/other_notes/)
* [Feature requests](http://frp.idea.informer.com/)
* [Bugs](http://wordpress.org/tags/flexible-recent-posts?forum_id=10#postform)
* [Donate (Flattr)](https://flattr.com/thing/646464)

**Translators:**

* Russian (ru) - [Paul Annekov](http://www.steelrat.info/en/)

== Installation ==

1. Upload `flexible-recent-posts` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to `wp-admin/widgets.php` page, move `Flexible Recent Posts` widget to any sidebar and change its defaults

== Frequently Asked Questions ==

= How can I change visual style of widget? =

You can edit `style.css` file in your theme adding needed styles. I will made some predefined styles in feature.

= I have created language pack or updated existing one. How can I send it to you? =

Send [gettext PO and MO files](http://codex.wordpress.org/Translating_WordPress) to me. You can find out my contacts [here](http://www.steelrat.info/en/contacts/).

== Screenshots ==

1. Widget options form
2. Widget on frontend

== Shortcodes ==

Plugin template system supports 5 shortcodes related to current widget post, that you can use in your template:

**Title** [frp_title]

Displays post title.

*Example*: `<h4>[frp_title]</h4>`

**Excerpt** [frp_excerpt]

Displays post excerpt using [get_the_excerpt](http://codex.wordpress.org/Function_Reference/get_the_excerpt "Visit function reference page") function.

*Example*: `<div class="excerpt">[frp_excerpt]</div>`

**Date** [frp_date format="F j, Y" time_since="0"]

Displays post date. You can add `format` shortcode parameter to change date format. Read about format value [here](http://codex.wordpress.org/Formatting_Date_and_Time "Visit customizing time and date reference page").
Add `time_since` parameter with 1 as value to display amount of elapsed time: `30 seconds ago`, `5 minutes ago`, `12 hours ago`, `3 Jun`.

*Example*: `<div class="date">[frp_date format="Y/m/d g:i:s A"]</div>`, `<div class="elapsed">[frp_date time_since="1"]</div>`

**Link** [frp_link]

Displays post permalink.

*Example*: `<a href="[frp_link]">read more</a>`

**Featured image** [frp_thumbnail size="32x32"]

Displays featured post image. Add `size` shortcode parameter to change image size. You can define size using WIDTHxHEIGHT as value or size name (built-in or defined in theme).

*Examples*: `[frp_thumbnail]`, `[frp_thumbnail size="thumbnail"]`, `[frp_thumbnail size="128x128"]`, `[frp_thumbnail size="full"]`

**Author** [frp_author link="1"]

Displays name of the post's author. Set `link` parameter to 0 if you want to disable link (author's site) from author name.

*Examples*: `[frp_author]`, `[frp_author link="1"]`, `[frp_author link="0"]`

== Changelog ==

= 0.3 =
* Added `[frp_author]` shortcode.
* Added `time_since` parameter to frp_date shortcode to display amount of elapsed time (like on twitter).

= 0.2 =
* Added global post replacement to make shortcodes more native. Now you can use plugin shortcodes in post content.
* Added categories list disable if 'All categories' checkbox is checked.
* Fixed PHP Notices if featured image exists in template with size defined as WIDTHxHEIGHT.
* Fixed shortcodes insert after widget form save.
* Fixed buttons actions on just created widgets on Widgets page.

= 0.1 =
* Init version.