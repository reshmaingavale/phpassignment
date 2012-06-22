<?php
echo $before_widget;

if ( !empty( $instance['title'] ) ) {
	echo $before_title . $instance['title'] . $after_title;

	if ( $instance['all_posts_link_title'] ):
		?>
	<a href="<?php print $category_link; ?>"
	   class="frp-all-category-news frp-all-category-news-header"><?php print $instance['all_posts_title']; ?></a>
	<?php
	endif;
}
?>
<div class="frp-clear"></div>
<ul class="frp-widget">
	<?php
	foreach ( $posts as $post ):
		// Replace global post variable with current looped post.
		$GLOBALS['post'] = $post;
		?>
		<li class="frp-news">
			<?php echo wpautop( do_shortcode( $instance['template'] ) ); ?>
		</li>
		<?php endforeach; ?>
</ul>
<?php if ( $instance['all_posts_link_footer'] ): ?>
<div class="frp-all-category-news frp-all-category-news-footer"><a
	href="<?php print $category_link; ?>"><?php print $instance['all_posts_title']; ?></a></div>
<?php endif; ?>
<?php echo $after_widget; ?>