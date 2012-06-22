<?php 
/**
 * Class used to create the event calendar widget
 */
class EO_Calendar_Widget extends WP_Widget
{

	var $w_arg = array(
		'title'=> '',
		);
	static $widget_cal =array();

	function __construct() {
		$widget_ops = array('classname' => 'widget_calendar eo_widget_calendar', 'description' => __('Displays a calendar of your events','eventorganiser') );
		parent::__construct('EO_Calendar_Widget', __('Events Calendar','eventorganiser'), $widget_ops);
  	}
 
	function form($instance)  {
	
		$instance = wp_parse_args( (array) $instance, $this->w_arg ); 	
		?>
	  	<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'eventorganiser'); ?>: </label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('showpastevents'); ?>"><?php _e('Include past events', 'eventorganiser'); ?>  </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('showpastevents'); ?>" name="<?php echo $this->get_field_name('showpastevents'); ?>" <?php checked($instance['showpastevents'],1);?> value="1" />
			</p>
		  <?php
	}
 

	function update($new_instance, $old_instance){
		$validated=array();
		$validated['title'] = sanitize_text_field( $new_instance['title'] );
		$validated['showpastevents'] = ( !empty($new_instance['showpastevents']) ? 1:  0);
		return $validated;
	}

 
 
	function widget($args, $instance){
		wp_enqueue_script( 'eo_front');
		extract($args, EXTR_SKIP);

		//Set the month to display (DateTIme must be 1st of that month)
		$tz = eo_get_blog_timezone();
		$month = new DateTime('now',$tz);
		$month = date_create($month->format('Y-m-1'),$tz);
	
		$calendar = array(
			'showpastevents'=> (empty($instance['showpastevents']) ? 0 : 1),
		);

		add_action('wp_footer', array(__CLASS__, 'add_options_to_script'));
		wp_enqueue_script( 'eo_front');
		$id = esc_attr($args['widget_id']);
		self::$widget_cal[$id] = $calendar;

		//Echo widget
    		echo $before_widget;
    		echo $before_title;
		echo esc_html($instance['title']);
    		echo $after_title;
		echo "<div id='{$id}_content' >";
		echo $this->generate_output($month,$calendar);
		echo "</div>";
    		echo $after_widget;
	}

	function add_options_to_script() {
		if(!empty(self::$widget_cal))
			wp_localize_script( 'eo_front', 'eo_widget_cal', self::$widget_cal);	
	}

/**
* Generates widget / shortcode calendar html
*
* param $month - DateTime object for first day of the month (in blog timezone)
*/
function generate_output($month,$args=array()){
	
	//Translations
	global $wp_locale;
	$months = $wp_locale->month;
	$monthsAbbrev = $wp_locale->month_abbrev;
	$weekdays = $wp_locale->weekday;
	$weekdays_initial =$wp_locale->weekday_initial;

	//Month should be a DateTime object of the first day in that month		
	$today = new DateTime('now',eo_get_blog_timezone());
	if(empty($args))
		$args=array();
	
	//Month details
	$firstdayofmonth= intval($month->format('N'));
	$lastmonth = clone $month;
	$lastmonth->modify('last month');	
	$nextmonth = clone $month;
	$nextmonth->modify('next month');
	$daysinmonth= intval($month->format('t'));

	//Retrieve the start day of the week from the options.
	$startDay=intval(get_option('start_of_week'));

	//How many blank cells before inserting dates
	$offset = ($firstdayofmonth-$startDay +7)%7;

	//Number of weeks to show in Calendar
	$totalweeks = ceil(($offset + $daysinmonth)/7);

	//Get events for this month
	$start = $month->format('Y-m-d');
	$end = $month->format('Y-m').'-'.$daysinmonth;

	$required = array( 'numberposts'=>-1, 'showrepeats'=>1, 'start_before'=>$end, 'start_after'=>$start );
	$query_array = array_merge($args,$required);

	$events=  eo_get_events($query_array);
	
	//Populate events array
	$tableArray =array();
	foreach($events as $event):
		$date = esc_html($event->StartDate);
		$tableArray[$date][]=  esc_attr($event->post_title);
	endforeach;


	$before = "<table id='wp-calendar'>";

	$title ="<caption>".esc_html($months[$month->format('m')].' '.$month->format('Y'))."</caption>";
	$head="<thead><tr>";
	for ($d=0; $d <= 6; $d++): 
			$day = $weekdays_initial[$weekdays[($d+$startDay)%7]];
			$head.="<th title='".esc_attr($day)."' scope='col'>".esc_html($day)."</th>";
	endfor;

	$head.="</tr></thead>";

	$prev = esc_html($monthsAbbrev[$months[$lastmonth->format('m')]]);
	$next = esc_html($monthsAbbrev[$months[$nextmonth->format('m')]]);
	$prev_link = add_query_arg('eo_month',$lastmonth->format('Y-m'));
	$next_link = add_query_arg('eo_month',$nextmonth->format('Y-m'));

	$foot = "<tfoot><tr>";
	$foot .="<td id='eo-widget-prev-month' colspan='3'><a title='".esc_html__('Previous month','eventorganiser')."' href='{$prev_link}'>&laquo; ".$prev."</a></td>";
	$foot .="<td class='pad'>&nbsp;</td>";
	$foot .="<td id='eo-widget-next-month' colspan='3'><a title='".esc_html__('Next month','eventorganiser')."' href='{$next_link}'>".$next."&raquo; </a></td>";
	$foot .= "</tr></tfoot>";

	$body ="<tbody>";

	$currentDate = clone $month;
		
	$event_archive_link = get_post_type_archive_link('event');
			
	for( $w = 0; $w <= $totalweeks-1; $w++ ):
		$body .="<tr>";
		$cell = $w*7;

		//For each week day
 		foreach ( $weekdays_initial as $i => $day ): 
			$cell = $cell+1;
			if( $cell<=$offset || $cell-$offset > $daysinmonth ){
					$body .="<td class='pad' colspan='1'>&nbsp;</td>";

			}else{
				$class=array();
				$formated_date =$currentDate->format('Y-m-d');

				//Is the date 'today'?
				if( $formated_date == $today->format('Y-m-d') )
					$class[] ='today';

				//Does the date have any events
				if( isset($tableArray[$formated_date]) ){
					$class[] ='event';
					$classes = implode(' ',$class);
					$classes = esc_attr($classes);

					$titles = implode(', ',$tableArray[$formated_date]);
					$titles = esc_attr($titles);

					$link = add_query_arg('ondate',$currentDate->format('Y-m-d'),$event_archive_link);
					$link = esc_url($link);

					$body .="<td class='".$classes."'> <a title='".$titles."' href='".$link."'>".($cell-$offset)."</a></td>";

				}else{
					$classes = implode(' ',$class);
					$body .="<td class='".$classes."'>".($cell-$offset)."</td>";
				}

				$currentDate->modify('+1 day');
			}

		 endforeach;//Endforeach Week day
		$body .="</tr>";

	endfor; //End for each week

	$body .="</tbody>";
	$after = "</table>";

	return $before.$title.$head.$foot.$body.$after;
}
 
}?>
