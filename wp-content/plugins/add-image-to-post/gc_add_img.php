<?php
/**
Plugin Name: Add Featured images
Plugin URI: http://www.appsmobiledev.com/wordpress-add-image-to-post-plugin
Description: Add images to your post and server from external link
Author: onigetoc
Version: 0.6
Author URI: http://www.appsmobiledev.com
 */

register_deactivation_hook(__FILE__, 'gc_add_deactivation');

function gc_add_deactivation() {
	delete_option('gimg_external'); 
	delete_option('gimg_custom_value'); 
	delete_option('gimg_in_post'); 
	delete_option('gimg_class'); 
}

//function gc_add_img() {
//	gc_featured_img('wp_head');
//}
//add_action( 'wp_footer', 'gc_featured_img' );
add_action( 'get_header', 'gc_featured_img' );
//add_action('get_header', 'gc_add_img');

// Main function Call all Functions
function gc_featured_img() { 

	if (is_single()) {
	
		$post_id = get_the_ID(); // Get Post ID
		$is_already_done = get_post_meta($post_id, "gc_thumb_checked", true);
		//if($is_already_done !== 'checked') { 	
		//if(get_post_meta($post_id, "gc_thumb_checked", true)){ //don't search image again if previously not found
		//if (empty($is_already_done)) {
		if ($is_already_done == '') {
		//if ( !has_post_thumbnail()) {  // Check if featured image exist !!!
		
 		$url = external_link($post_id); // Funtion to get external link if not continu
		$url = htmlspecialchars_decode($url); // Need htmlspecialchars_decode to work

		$get_redirect = redirec_url_link($url); // Find the real link - may be a redirect link or bit.ly ect

			if (!empty($get_redirect)) { // Continu if external url exist
			$get_pic = grab_pic($get_redirect); // Funtion to grab the first image from source page
			}
			
			if (isset($get_pic)) { // Continu if image is found
			$ext_link = upload_featured($get_pic,$post_id);  // upload image and make featured
			}
		}
	}
	
} 

// Find External link

function external_link($post_id) { 
update_post_meta( $post_id, 'gc_thumb_checked', 'checked' ); // add post meta to tell if already try to find img previously 

$gimg_custom_value = get_option('gimg_custom_value'); 
//$gimg_custom_value = trim($gimg_custom_value);
$gimg_external = get_option('gimg_external'); 

if($gimg_external == 'gimg_content') { 

//Do find external link in content
	$queried_post = get_post($post_id);
	$contents = $queried_post->post_content;
	//Get the urls out of the page 
	preg_match_all("/href=\"(.*?)\"/", $contents, $matches); 
	foreach($matches[1] as $link) 
	{   
		$pos = strpos($link, current_domain());
    	if ($pos == false) {
        	$get_ext_link = $link;  
			return $get_ext_link;  
			break; 
			
    	}          
	} 
//Do find external link in content END
}else {

	if($gimg_external == 'gimg_autoblog') { 

		if(get_post_meta($post_id, "external_link", true)) // for autoblogged 
			{  
			$get_ext_link = get_post_meta($post_id , "external_link", true);
			return $get_ext_link; 
			}
		if(get_post_meta($post_id, "link", true)) // for autoblogged old
			{  
			$get_ext_link = get_post_meta($post_id , "link", true);
			return $get_ext_link; 
			}
		if(get_post_meta($post_id, "source", true)) // for WP robot
			{  
			$get_ext_link = get_post_meta($post_id , "source", true); 
			return $get_ext_link; 
			}
	}else { 
		if(get_post_meta($post_id, $gimg_custom_value, true)) // get Custom post meta Value to external link
		{  
		$get_ext_link = get_post_meta($post_id , $gimg_custom_value, true); 
		return $get_ext_link; 
		}
	}
	
}
	
} 
 
// Look for external link redirect
function redirec_url_link($url) { 
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);

	$result = curl_exec($ch); 

	if (preg_match("/Location\:/","$result")) {
	$url = explode("Location: ",$result);
	$reversed_url = explode("\r",$url[1]);
	return $reversed_url[0];
	} else {
	return $url; 
	// original print_r($result);
	}

} 
//Scrap images
function grab_pic($ext_url) { 

    if( $ext_url ){
	if( !strstr($ext_url,"http://") && !strstr($ext_url,"https://") ){
		$ext_url = "http://".$ext_url;	  
	}}

$text = @file_get_contents($ext_url);

$motif='/src=[\'"]?([^\'" >]+(jpe?g|JPE?G|png|PNG))[\'"]?/im'; // Regex to Look for PNG or Jpeg image only, not gif

preg_match_all($motif,$text,$out,PREG_PATTERN_ORDER);

foreach ($out[1] as $link) {
if( $link ){
	if( !strstr($link,"http://") && !strstr($link,"https://") ){
		
	$showhost = $ext_url; 
	$showhost = parse_url($showhost);		 
	$link = "http://{$showhost['host']}/".$link; }} // Sometime the image url is not complete with base url and path	
	//print_r ($link);
		
	list($width, $height, $type, $attr) = @getimagesize($link);

		if ($width > 124 and $height > 130 ) { //look for image equal or bigger than these value
	 	//echo $link.'<br>';
		$img_link = $link;
	 	break;
		}
	
	}
        return $img_link; 
} 
//Scrap images end

function upload_featured($img_url,$post_id) { 
 	//Find upload directory
	$upload_dir = wp_upload_dir();
	$upload_dir_base = $upload_dir['baseurl'];
	//Find upload directory done 
 
 	$path_parts = pathinfo($img_url); 
	$filename = $path_parts['basename'];

	$file = $img_url;
	//$newfile = ''.$upload_dir_base.'/'.$filename.'';
	$newfile = 'wp-content/uploads/'.$filename.'';

	if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
	}
 
  $wp_filetype = wp_check_filetype(basename($newfile), null );
  $attachment = array(
     'post_mime_type' => $wp_filetype['type'],
     'post_title' => preg_replace('/\.[^.]+$/', '', basename($newfile)),
     'post_content' => '',
     'post_status' => 'inherit'
  );

  $attach_id = wp_insert_attachment( $attachment, $newfile, $post_id );
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  $attach_data = wp_generate_attachment_metadata( $attach_id, $newfile );
  wp_update_attachment_metadata( $attach_id, $attach_data );
  
  update_post_meta( $post_id, '_thumbnail_id', $attach_id ); // Make thumbs post-thumbnail or Featured
  $full_img_url = get_bloginfo('url').'/'.$newfile;
  update_post_meta( $post_id, 'gc_thumb', $full_img_url ); // Add a custom field of img url
  //update_post_meta( $post_id, 'gc_thumb_checked', 'checked' ); // look at this custom field to not run script if image was previousely not found

		// Add image in Post
		$gimg_in_post = get_option('gimg_in_post'); 
		$gimg_class = get_option('gimg_class'); 

  		if($gimg_in_post == 'checked') { 		
			
			if (!empty($gimg_class)) { // Continu if external url exist
			$class = $gimg_class;
			} else {
  			$class = 'alignleft';
			}

			$title = get_the_title($post_id);
			
			$queried_post = get_post($post_id);
			$contents = $queried_post->post_content;
			
			$img_url = '<img src="'.$full_img_url.'" class="'.$class.'" />';
			$update_content = $img_url.''. $contents;
		
			$my_post = array(
  			'ID' => $post_id,
			'post_title' => $title,
    		'post_content' => $update_content,
    		//'post_status' => 'publish',
    		//'post_author' => 1,
			//'post_category' => array(8,39)
 			);
			// Insert the post into the database
 		 	wp_update_post( $my_post );
			
		}
		// Add image in Post END
		
}
// Upload image as featured end
?>
<?php
function current_domain() {
	$host = $_SERVER['HTTP_HOST'];
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
	$domain = $matches[0];
	return $domain;
}
?>
<?php
function gimg_settings()
{
	// this is where we'll display our admin options
	if ($_POST['action'] == 'update')
	{		
		$gimg_external = $_POST['gimg_external'];  
        update_option('gimg_external', $gimg_external); 
		
		$gimg_custom_value = $_POST['gimg_custom_value'];  
        update_option('gimg_custom_value', $gimg_custom_value); 
		
		$gimg_in_post = $_POST['gimg_in_post'];  
        update_option('gimg_in_post', $gimg_in_post);
		
		$gimg_class = $_POST['gimg_class'];  
        update_option('gimg_class', $gimg_class);	
		
		$message = '<div id="message" class="updated fade"><p><strong>Options Saved</strong></p></div>';

	}
	
	$gimg_external = get_option('gimg_external'); 
	$gimg_custom_value = get_option('gimg_custom_value');   
	$gimg_custom_value = trim($gimg_custom_value);
	$gimg_in_post = get_option('gimg_in_post'); 
	$gimg_class = get_option('gimg_class'); 

?>
  <?php 
 echo '<br><div class="wrap">
		'.$message.'
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Add image to Post Settings</h2>

		<form method="post" action="">
		<input type="hidden" name="action" value="update" />'?>
 
  <?php echo $message_right = '<div id="sidebar" class="sidebar" style="float: right; width: 260px; z-index:999; "><div align="center"><iframe src="http://www.scriptsmashup.com/sidebar/sidebar.php?name==gc-image" border=0 width=250 height=500></iframe></div></div>';?>
<div id="poststuff" class="postbox" style="width: 65%;">  
<h3>External links <em>(Source to find images)</em></h3>
<div class="inside">
<input <?php if ($gimg_external == 'gimg_autoblog') echo 'checked'; ?> type="radio" name="gimg_external" value="gimg_autoblog" /> 
         External link from Autoblogged / WP robot <em> (If it doesn't work, try custom field)</em><br />
         
<input <?php if ($gimg_external == 'gimg_content') echo 'checked'; ?> type="radio" name="gimg_external" value="gimg_content" /> 
         External link from post content <em> (Find the first external link in blog content)</em><br />
         
<input <?php if ($gimg_external == 'gimg_custom') echo 'checked'; ?> type="radio" name="gimg_external" value="gimg_custom" /> 
         Custom field: 
         <input name="gimg_custom_value" type="text" value="<?php if (strlen($gimg_custom_value) >= 1) {echo $gimg_custom_value;}else {echo '';}?>" size="10" />
         <em>(Do your blog already have a custom field to external link?)</em> <a href="#">*help</a><br />
  </div>    
</div>      

<div id="poststuff" class="postbox" style="width: 65%;"> 
<h3>Image in post options</h3>
	<div class="inside">

<input <?php echo $gimg_in_post ?> type="checkbox" name="gimg_in_post" value="checked" /> 
Insert image in post <em>(added at the top)</em>
<br />
<br />


<input name="gimg_class" type="text" value="<?php if (strlen($gimg_class) >= 1) {echo $gimg_class;}else {echo '';}?>" size="10" /> 
 Enter your own image css  class <em>(alignleft)</em><br />
  </div>    
</div>     
		<input type="submit" class="button-primary" value="Save Changes" />
		</form>
	</div>
<?php } // End Setting function ?>
<?php 
// Admin plugin setting
function gimg_admin_menu()
{
	// this is where we add our plugin to the admin menu
	add_options_page('Add image to post options', 'GC Add images', 9, basename(__FILE__), 'gimg_settings');
}

add_action('admin_menu', 'gimg_admin_menu');

add_action('plugin_action_links_' . plugin_basename(__FILE__), 'gimg_adminbar');
function gimg_adminbar($links){

	$new_links = array();

	$adminlink = get_bloginfo('url').'/wp-admin/';

	$gimg_link = 'http://www.appsmobiledev.com/';

	$new_links[] = '<a href="'.$adminlink.'options-general.php?page=gc_add_img.php">Settings</a>';

	return array_merge($links,$new_links );

}
?>