<?php
/**
 * Class used to create the event calendar shortcode
 *
 *@uses EO_Calendar Widget class to generate calendar html
 */
class EventOrganiser_Shortcodes {
	static $add_script;
	static $calendars =array();
	static $widget_calendars =array();
	static $map = array();
	static $event;
 
	function init() {
		add_shortcode('eo_calendar', array(__CLASS__, 'handle_calendar_shortcode'));
		add_shortcode('eo_fullcalendar', array(__CLASS__, 'handle_fullcalendar_shortcode'));
		add_shortcode('eo_venue_map', array(__CLASS__, 'handle_venuemap_shortcode'));
		add_shortcode('eo_events', array(__CLASS__, 'handle_eventlist_shortcode'));
		add_shortcode('eo_subscribe', array(__CLASS__, 'handle_subscription_shortcode'));
		add_action('wp_footer', array(__CLASS__, 'print_script'));
	}
 
	function handle_calendar_shortcode($atts) {
		global $post;
		self::$add_script = true;
		self::$widget_calendars[] =true;
		$id = count(self::$calendars);

		$tz = eo_get_blog_timezone();
		$month = new DateTime('now',$tz);
		$month = date_create($month->format('Y-m-1'),$tz);
		$html = '<div class="widget_calendar eo-calendar eo-calendar-shortcode eo_widget_calendar" id="eo_shortcode_calendar_'.$id.'">';
		$html .= '<div id="eo_shortcode_calendar_'.$id.'_content">'.EO_Calendar_Widget::generate_output($month).'</div>';
		$html .= '</div>';

		return $html;
	}

	function handle_subscription_shortcode($atts, $content=null) {
		extract( shortcode_atts( array(
			'title' => 'Subscribe to calendar',
			'type' => 'google',
		      'class' => '',
		      'id' => '',
		), $atts ) );

		$url = add_query_arg('feed','eo-events',site_url());

		$class = esc_attr($class);
		$title = esc_attr($title);
		$id = esc_attr($id);
		
		if(strtolower($type)=='webcal'):
			$url = str_replace( 'http://', 'webcal://',$url);
		else:
			$url = add_query_arg('cid',urlencode($url),'http://www.google.com/calendar/render');
		endif;

		$html = '<a href="'.$url.'" target="_blank" class="'.$class.'" title="'.$title.'" id="'.$id.'">'.$content.'</a>';
		return $html;
	}

	function handle_fullcalendar_shortcode($atts=array()) {
		global $post;
		$defaults = array(
			'headerleft'=>'title', 
			'headercenter'=>'',
			'headerright'=>'prev,next today',
			'defaultview'=>'month',
			'category'=>'',
			'venue'=>'',
			'timeformat'=>'H:i',
			'key'=>'false'
		);
		$atts = shortcode_atts( $defaults, $atts );
		array_map('esc_attr',$atts);

		$key = ($atts['key']=='true' ? true : false);
		unset($atts['key']);

	
		//Convert php time format into xDate time format
		$atts['timeformat'] =eventorganiser_php2xdate($atts['timeformat']);

		self::$calendars[] =array_merge($atts);
		self::$add_script = true;
		$id = count(self::$calendars);

		$html='<div id="eo_fullcalendar_'.$id.'_loading" style="background:white;position:absolute;z-index:5" >';
		$html.='<img src="'.esc_url(EVENT_ORGANISER_URL.'/css/images/loading-image.gif').'" style="vertical-align:middle; padding: 0px 5px 5px 0px;" />'.__('Loading&#8230;').'</div>';
		$html.='<div class="eo-fullcalendar eo-fullcalendar-shortcode" id="eo_fullcalendar_'.$id.'"></div>';
		if($key){
			$args = array('orderby'=> 'name','show_count'   => 0,'hide_empty'   => 0);
			$html .= eventorganiser_category_key($args,$id);
		}
 		return $html;
	}

	function handle_venuemap_shortcode($atts) {
		global $post;
		self::$add_script = true;
		//If venue is not set get from the venue being quiered or the post being viewed
		if( empty($atts['venue']) ){
			if( eo_is_venue() ){
				$atts['venue']= esc_attr(get_query_var('term'));
			}else{
				$atts['venue'] = eo_get_venue_slug(get_the_ID());
			}
		}

		$venue_id = eo_get_venue_id_by_slugorid($atts['venue'] );

		return self::get_venue_map($venue_id, $atts);
	}


	function get_venue_map($venue_id, $args){

		self::$add_script = true;

		extract( shortcode_atts( array(
			'zoom' => 15,
			'width' => '100%',
			'height' => '200px',
		      'class' => ''
			), $args ) );


		//Set zoom
		$zoom = (int) $zoom; 
		
		//Set the attributes
		$width = esc_attr($width);
		$height = esc_attr($height);

		 //If class is selected use that style, otherwise use specified height and width
		if( !empty($class) ){
			$class = esc_attr($class)." eo-venue-map googlemap";
			$style="";
		}else{
			$class ="eo-venue-map googlemap";
			$style="style='height:".$height.";width:".$width.";' ";
		}
		
		//Get latlng value by slug
		$latlng = eo_get_venue_latlng($venue_id);
		self::$map[] =array('lat'=>$latlng['lat'],'lng'=>$latlng['lng'],'zoom'=>$zoom);
		$id = count(self::$map);

		$return = "<div class='".$class."' id='eo_venue_map-{$id}' ".$style."></div>";
		return $return;
	}
 

	function handle_eventlist_shortcode($atts=array(),$content=null) {
		global $post;
		$tmp_post = $post;

		$taxs = array('category','tag','venue');
		foreach ($taxs as $tax){
			if(isset($atts['event_'.$tax])){
				$atts['event-'.$tax]=	$atts['event_'.$tax];
				unset($atts['event_'.$tax]);
			}
		}

		if((isset($atts['venue']) &&$atts['venue']=='%this%') ||( isset($atts['event-venue']) && $atts['event-venue']=='%this%' )){
			if(!empty($post->Venue)){
				$atts['event-venue']=  eo_get_venue_slug();
			}else{
				unset($atts['venue']);
				unset($atts['event-venue']);
			}
		}

		$events = eo_get_events($atts);
		$tz = eo_get_blog_timezone();

		if($events):	
			$return= '<ul class="eo-events eo-events-shortcode">';
			foreach ($events as $post):
				setup_postdata($post); 

				//Check if all day, set format accordingly
				if(eo_is_all_day()){
					$format = get_option('date_format');
				}else{
					$format = get_option('date_format').'  '.get_option('time_format');
				}
				$dateTime = new DateTime($post->StartDate.' '.$post->StartTime, $tz);
				
				if(empty($content)):
					$return .= '<li><a title="'.the_title_attribute(array('echo'=>false)).'" href="'.get_permalink().'">'.get_the_title().'</a> '.__('on','eventorganiser').' '.eo_format_date($post->StartDate.' '.$post->StartTime, $format).'</li>';

				else:
					$return .= '<li>'.self::read_template($content).'</li>';
				endif;

			endforeach;
			$return.='</ul>';
			$post = $tmp_post;
			wp_reset_postdata();

			return $return;
		endif;
	}
	
	function read_template($template){
		$patterns = array();	
		//TODO ICAL/Google link
		$patterns[0] = '/%(event_title)%/';
		$patterns[1] = "/%(start)({([^{}]+)}{([^{}]+)}|{[^{}]+})%/";
		$patterns[2] = "/%(end)({([^{}]+)}{([^{}]+)}|{[^{}]+})%/";
		$patterns[3] = '/%(event_venue)%/';
		$patterns[4] = '/%(event_venue_url)%/';
		$patterns[5] = '/%(event_cats)%/';
		$patterns[6] = '/%(event_tags)%/';
		$patterns[7] = '/%(event_venue_address)%/';
		$patterns[8] = '/%(event_venue_postcode)%/';
		$patterns[9] = '/%(event_venue_country)%/';
		$patterns[10] = "/%(schedule_start)({([^{}]+)}{([^{}]+)}|{[^{}]+})%/";
		$patterns[11] = "/%(schedule_end)({([^{}]+)}{([^{}]+)}|{[^{}]+})%/";
		$patterns[12] = '/%(event_thumbnail)({[^{}]+})?%/';
		$patterns[13] = '/%(event_url)%/';
		$patterns[14] = '/%(event_custom_field){([^{}]+)}%/';
		$patterns[15] = '/%(event_venue_map)({[^{}]+})?%/';
		$patterns[16] = '/%(event_excerpt)%/';
		$patterns[17] = '/%(cat_color)%/';
		
		$template = preg_replace_callback($patterns, array(__CLASS__,'parse_template'), $template);
		return $template;
	}
	
	function parse_template($matches){
		global $post;
		$replacement='';
		$col = array(
			'start'=>array('date'=>'StartDate','time'=>'StartTime'),
			'end'=>array('date'=>'EndDate','time'=>'FinishTime'),
			'schedule_start'=>array('date'=>'reoccurrence_start','time'=>'StartTime'),
			'schedule_end'=>array('date'=>'reoccurrence_end','time'=>'FinishTime')
		);
		
		switch($matches[1]):
			case 'event_title':
				$replacement = get_the_title();
				break;
				
			case 'start':
			case 'end':
			case 'schedule_start':
			case 'schedule_end':
				switch(count($matches)):
					case 2:
						$dateFormat = get_option('date_format');
						$dateTime = get_option('time_format');
						break;
					case 3:
						$dateFormat =  self::eo_clean_input($matches[2]);
						$dateTime='';
						break;
					case 5:
						$dateFormat =  self::eo_clean_input($matches[3]);
						$dateTime =  self::eo_clean_input($matches[4]);
						break;
				endswitch;
		
				if( eo_is_all_day(get_the_ID()) ){
					$replacement = eo_format_date($post->$col[$matches[1]]['date'].' '.$post->$col[$matches[1]]['time'], $dateFormat);
				}else{	
					$replacement = eo_format_date($post->$col[$matches[1]]['date'].' '.$post->$col[$matches[1]]['time'], $dateFormat.$dateTime);					
				}
				break;
			case 'event_tags':
				$replacement = get_the_term_list( get_the_ID(), 'event-tag', '', ', ',''); 
				break;

			case 'event_cats':
				$replacement = get_the_term_list( get_the_ID(), 'event-category', '', ', ',''); 
				break;

			case 'event_venue':
				$replacement =eo_get_venue_name();
				break;

			case 'event_venue_map':
				if(eo_get_venue()){
					$class = (isset($matches[2]) ? self::eo_clean_input($matches[2]) : '');
					$class = (!empty($class) ?  'class='.$class : '');
					$replacement = do_shortcode('[eo_venue_map '.$class.']');
				}
				break;

			case 'event_venue_url':
				$replacement =eo_get_venue_link();
				break;
			case 'event_venue_address':
				$address = eo_get_venue_address();
				$replacement =$address['address'];
				break;
			case 'event_venue_postcode':
				$address = eo_get_venue_address();
				$replacement =$address['postcode'];
				break;
			case 'event_venue_country':
				$address = eo_get_venue_address();
				$replacement =$address['country'];
				break;
			case 'event_thumbnail':
				$size = (isset($matches[2]) ? self::eo_clean_input($matches[2]) : '');
				$size = (!empty($size) ?  $size : 'thumbnail');
				$replacement = get_the_post_thumbnail(get_the_ID(),$size);
				break;
			case 'event_url':
				$replacement =  get_permalink();
				break;
			case 'event_custom_field':
				$field = $matches[2];
				$meta = get_post_meta(get_the_ID(), $field);
				$replacement =  implode($meta);
				break;
			case 'event_excerpt':
				//Using get_the_excerpt adds a link....
				if ( post_password_required($post) ) {
					$output = __('There is no excerpt because this is a protected post.');
				}else{
					$output = $post->post_excerpt;
				}
				$replacement = wp_trim_excerpt($output);
				break;
			case 'cat_color':
				$replacement =  eo_event_color();
				break;
		endswitch;
		return $replacement;
	}

	function eo_clean_input($input){
		$input = trim($input,"{}"); //remove { }
		$input = str_replace(array("'",'"',"&#8221;","&#8216;", "&#8217;"),'',$input); //remove quotations
		return $input;
	}
 
	function print_script() {
		global $wp_locale;
		if ( ! self::$add_script ) return;
		$fullcal = (empty(self::$calendars) ? array() : array(
			'firstDay'=>intval(get_option('start_of_week')),
			'venues' => get_terms( 'event-venue', array('hide_empty' => 0)),
			'categories' => get_terms( 'event-category', array('hide_empty' => 0)),
		));
		wp_localize_script( 'eo_front', 'EOAjax', 
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php'),
			'calendars' => self::$calendars,
			'fullcal' => $fullcal,
			'map' => self::$map,
		));	
		if(!empty(self::$calendars)):
			wp_enqueue_style('eo_calendar-style');		
		endif;
		wp_enqueue_script( 'eo_front');	
	}
}
 
EventOrganiser_Shortcodes::init();

/*
* Very basic class to convert php date format into xdate date format used for javascript.
*
* Doesn't support
* ** L Whether it's a leap year
* ** N ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)
* ** w Numeric representation of the day of the week (0=sun,...)
* ** z The day of the year (starting from 0)
* ** t Number of days in the given month
* **B Swatch Internet time
* **u microseconds

* ** e 	Timezone identifier (added in PHP 5.1.0) 	Examples: UTC, GMT, Atlantic/Azores
* ** I (capital i) 	Whether or not the date is in daylight saving time 	1 if Daylight Saving Time, 0 otherwise.
* ** O 	Difference to Greenwich time (GMT) in hours 	Example: +0200
* ** T 	Timezone abbreviation 	Examples: EST, MDT ...
* ** Z 	Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.

* ** c 	ISO 8601 date (added in PHP 5) 	2004-02-12T15:19:21+00:00
* ** r 	» RFC 2822 formatted date 	Example: Thu, 21 Dec 2000 16:01:07 +0200
* ** U 	Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT) 	See also time()
*/
	function eventorganiser_php2xdate($phpformat=""){
		$php2xdate = array(
				'Y'=>'yyyy','y'=>'yy','L'=>''/*NS*/,'o'=>'I',
				'j'=>'d','d'=>'dd','D'=>'ddd','l'=>'dddd','N'=>'', /*NS*/ 'S'=>'S',
				'w'=>'', /*NS*/ 'z'=>'',/*NS*/ 'W'=>'w',
				'F'=>'MMMM','m'=>'MM','M'=>'MMM','n'=>'M','t'=>'',/*NS*/
				'a'=>'tt','A'=>'TT',
				'B'=>'',/*NS*/'g'=>'h','G'=>'H','h'=>'hh','H'=>'HH','u'=>'fff',
				'i'=>'mm','s'=>'ss',
				'O'=>'zz ', 'P'=>'zzz',
				'c'=>'u',
			);
		$xdateformat="";

		for($i=0;  $i< strlen($phpformat); $i++){

			//Handle backslash excape
			if($phpformat[$i]=="\\"){
				$xdateformat .= "\\".$phpformat[$i+1];
				$i++;
				continue;
			}

			if(isset($php2xdate[$phpformat[$i]])){
				$xdateformat .= $php2xdate[$phpformat[$i]];
			}else{
				$xdateformat .= $phpformat[$i];
			}
		}
		return $xdateformat;
	}

	function eventorganiser_category_key($args=array(),$id=1){
		$args['taxonomy'] ='event-category';

		$html ='<div class="eo-fullcalendar-key" id="eo_fullcalendar_key'.$id.'">';
		$terms = get_terms( 'event-category', $args );
		$html.= "<ul class='eo_fullcalendar_key'>";
		foreach ($terms as $term):
			$slug = esc_attr($term->slug);
			$color = esc_attr($term->color);
			$class = "class='eo_fullcalendar_key_cat eo_fullcalendar_key_cat_{$slug}'";
			$html.= "<li {$class}><span class='eo_fullcalendar_key_colour' style='background:{$color}'>&nbsp;</span>".esc_attr($term->name)."</li>";			
		endforeach;
		$html.='</ul></div>';

		return $html;
	}
?>
