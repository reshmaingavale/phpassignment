=== Event Organiser ===
Contributors: stephenh1988
Donate link: http://www.harriswebsolutions.co.uk/event-organiser/
Tags: events, event, event categories, event organiser, event calendar, events calendar, event management, ical, locations, google map, widget, venues, maps, gigs, shows,
Requires at least: 3.3
Tested up to: 3.4
Stable tag: 1.4.1

Create and maintain events, including complex reoccurring patterns, venue management (with Google maps), calendars and customisable event lists

== Description ==

Event Organiser adds event management that integrates well with your WordPress site. By using WordPress' in-built 'custom post type', this plug-in allows you to create events that have the same functionality as posts, while adding further features that allow you to manage your events. This includes the possibility of repeating your event according to complex schedules and assign your events to venues. This can all be done through an intuitive user interface, which allows your to view your events in the familiar WordPress list or view all occurrences of your events in a calendar page in the amin area.

= New Features =
* Custom fields and metaboxes for venues
* Improved add events link to menu option
* Templates for widgets (syntax as for event list shortcode)
* Time format option for full calender shortcode
* Quick/Bulk edit event venue
* `eo_get_events` and the event list shortcode now support relative date formats for data parameters (e.g. `event_start_before='+1 week'`,`event_end_after='now'`)


= Features =

* Adds an **event custom post type** that fits naturally into WordPress and allows for all the functionality of 'posts'.
* Create one-time events or reoccuring events.
* Allows complex reoccuring patterns for events. You can create events that last an arbirtary time, and repeat over a specified period. Events can repeat daily through to yearly, allowing complex schedules such as 'On the third Tuesday of every fourth month' or 'Every month on the 16th'.
* **Venue admin page** to add and maintain the venues for your events, with Google maps support to display a map of the venue and a fully-featured content editor.
* Custom metaboxes and meta data support for venues.
* The **Calendar widget**  displays a calendar (identical to the standard WordPress Calendar) that highlights events with links to the events archive page, listing events occuring that day.
* The **Event List widget**  outputs a list of events, and allows you to specify the number of events, restrict to event categories or venues and their order etc.
* The **Event Agent widget**.
* The **Calendar and Event List shortcodes**, similiar to their respective widgets, for use in themes or in posts and pages.
* Shortcode to dislay a public version of the admin **'full calendar'**.
* The **Venue map shortcodes** to display a map of a venue.
*  **Custom permissions** allow to specifiy which roles have the ability to create, edit and delete events or manage venues.
* **Template** pages include in the plug-in for 'quick-start'. These can be over-ridden by including the appropriately named template files in your theme folder.
* **Event functions** available which extend the post functions (e.g. `the_title()`,`get_the_author()`, `the_author()`) to ouput or return event data (the start date-time, the venue etc). For examples of their use see the [documentation](http://www.harriswebsolutions.co.uk/event-organiser/documentation/function-reference/) or the included template files.
* Assign events to categories and tags, and view events by category or tag.
* Color-coded event categories.
* Venue pages, to view events by venue.
* **Export/import** events to and from ICAL files.
* Delete individual occurrences of events.
* **Public events feed:** allow visitors to subscribe to your events.
* Supports 'pretty permalinks' for event pages, event archives, event category and venue pages.
* (Optionally) automatically delete expired events.


= Planned Features =

* Introducing actions and filters to allow developers or plug-ins to modify and interact with Event Organiser.
* Allowing users to exclude or include specific dates in an event's schedule.
* Dashboard widgets (upcoming events / expiring events).

= Localisation =
A big thank you to those who have provided translations for Event Organiser

* French - [RÃ©my Perona](http://remyperona.fr/)
* Spanish - Joseba Sanchez
* German - [Martin Grether](http://www.datema.de/) & [Henning Matthaei](http://www.partnerwerk.de/)
* Italian - Emilio Frusciante, Pio Muto
* Norwegian - Erlend Birkedal
* Swedish - Sofia BrÃ¥vander
* Portuguese (Brazilian) - [Rafael Wahasugui](http://www.twitter.com/rafawhs)
* Dutch  - [Ingrid Ekkers](http://www.247design.nl)
* Polish - [Bartosz Arendt](http://digitalfactory.pl/)


== Installation ==

Installation is standard and straight forward. 

1. Upload `event-organiser` folder (and all it's contents!) to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Check the settings sub-page of the Events menu


== Frequently Asked Questions ==

= How to create an event =

Events behave very similarly to standard posts. To create a event, select the 'Add New' submenu from 'Events' menu. The chief difference between events and post is the 'Event Details' metabox which sets the date and venue data related to the event.

You can also add events in the Calendar view in a manner similiar to Google Calendar. By selecting one (or multiple) days (in month mode) or times (in week/day mode) you can create an event that spans the selected period. 


= How do I display events? =

Events are automatically displayed on the events page: try `www.your-wordpress-site.com/?post_type=event` (If you have permalinks enabled these will have 'prettier' versions). Similarly, `?event-category=` would display events of a specfied category, and `?venue=`, events at specified venue. FInally `?event=` will show the specified event.

Each of the above have their own associated template. These template files are present in the template sub-directory of the Event-Organiser plug-in folder. To override the default templates, simply create the appropriately named files in your theme directory.

The plug-in also provides the following widgets:

* Event list - list events allows with options to filter by venue, categories and dates.
* Calendar - display a calendar, similiar to the WordPress calendar, that displays your events.
* Agenda - displays your events in a list grouped by date and navigated with AJAX.

and, among others, the following shortcodes:

* Event list & Widget Calendar - shortcode versions of their widget counterparts.
* Full calendar - a calendar, similiar to the admin calendar, with optional month, week and day views and category and venue filters

Finally, the plug-in provides a function `eo_get_events` which is similiar to WordPress' `get_posts`. The function returns an array of post objects (where the posts are events), and this can be used to display events through editing your theme. The usual WordPress functions for display associated information (author, title etc) are still available to you, and the plug-in provides a similar set of functions to display event related data (dates, venues etc). See the [documentation](http://www.harriswebsolutions.co.uk/event-organiser/documentation/function-reference/).


= The full calendar doesn't display any events =

The calendar should display all published events. If you find the calendar doesn't appear this is usually caused by the theme you are using, and is verifiable by temporarily switching to the TwentyEleven theme. If the theme is the cause this is normally because:

* The theme de-registers the jQuery / jQuery UI shipped with WordPress and registers an outdated version
* The theme does not call [`wp_footer`](http://codex.wordpress.org/Function_Reference/wp_footer) in the footer

If the calendar *does* appear, but gets stuck loading, the cause is usually the AJAX response. If your site is in 'debug' mode - this can be due to error messages from other plug-ins being printed. You can view the AJAX response in your browsers console (E.g. Firefox's firebug or Chrome's dev tools). If you are still unable to determine the cause of the problem, or how to fix, please use the plug-in forums with a link to your site and I'll take a look.


= I cannot navigate between months on the widget calendar =

If clicking on the 'next' month causes the page to reload - the javascript has not been loaded. This is usually because the theme does not call [`wp_footer`](http://codex.wordpress.org/Function_Reference/wp_footer) in the footer. 

If the calendar simply does not respond this is usually because your theme does not allow widgets to add their own ID and classes. If you are still unable to determine the cause of the problem, or how to fix, please use the plug-in forums with a link to your site and I'll take a look.


= What ShortCodes are available? = 

Event Organiser provides the following shortcodes:

* `[eo_events]`  - displays a list of events allows with options to filter by venue, categories and dates.
* `[eo_calendar]`  - displays a widget-calendar of your events, similiar to WordPress' calendar, and navigated with AJAX.
* `[eo_fullcalendar]`  - displays a calendar, similiar to the admin calendar, with optional month, week and day views and category and venue filters.
* `[eo_venue_map]` - displays a Google map of the current venue, or of a particular venue given as an attribute.
* `[eo_subscribe]` - wraps the content in a link which allows visitors to subscribe to your events; there are two types: 'Google' and 'Webcal'.


== Screenshots ==

1. Event admin screen
2. Venue admin screen
3. Event details metabox, showing the full reoccurrence options and venue selection
4. Venue editing screen, with Google Maps
5. Calendar View screen
6. View of a venue page on the front-end (in a theme based on WordPress TwentyEleven)

== Changelog ==

= 1.4.1 =
* Fixes a [weekly schedule bug](http://www.harriswebsolutions.co.uk/event-organiser/forums/topic/1-4-update-weekly-recurring-days-of-week-array-error/#post-2278), occurs for some users.

= 1.4 =
* A big update: venue address data migrated to new venue meta table
* Introduces support for venue meta data and custom metaboxes (see )
* Improved venue admin page UI

= 1.3.6 =
* Works with WordPress 3.4

= 1.3.5 =
* Fixed events export bug.
* Cached timezone object, improved performance.


= 1.3.4 =
* `%cat_color%` now works
* Fixed IE8+ calendar and agenda bugs
* Fixed shortcode calendar bug
* Fixed timezone for 'add to google' link


= 1.3.3 =
* Added 'no events' option for event list widget
* Added template tags for widget/shortcode: `%cat_color%` and `%event_excerpt%`
* Added hook `eventorganiser_calendar_event_link` to alter full calendar event link
* Added `eo_has_event_started`, `eo_has_event_finished`, `eo_event_color`,`eo_get_blog_timezone` functions
* Fixed the following bugs
 * Widget calendar (affecting some themes)
 *  Agenda date 'undefined' (affecting some browsers)
 * HTML in widget template breaking form
 * Fullcalendar in IE6/7
 * Event-tag template not loading
 *Other minor bugs


= 1.3.2 =
* Fixes permalink bug introduced in 1.3.1

= 1.3.1 =
* 'Clever' template hierarchy. Recognises templates for specific venues, categories or tags. E.g. `taxonomy-event-venue-myvenueslug.php`
* Fixed menu related bugs
* Fixed bulk/quick edit errors
* Fixed numeric venue slug bug
* Widget calendar - added class 'today' to current date and 'show past events' option
* Fixed calendar key (chrome browser) bug
* Pretty Permalinks can now be turned off

= 1.3 =
* Converted venues to event-venue taxnomy terms
* Improved add events link to menu option
* Import Categories and Venues
* Break a reoccurring event
* Templates for widgets (syntax as for event list shortcode)
* Time format option for full calender shortcode
* Quick/Bulk edit event venue
* Category key option for full calendar shortcode
* Set zoom level on venue map shortcode
* Full calendar shortcode attribute to restrict events to a specific venue / category
* Fixed 'daylight saving' bug for php5.2
* Fixed IE7 Widget calendar bug (thanks to [Fej](http://wordpress.org/support/profile/fej) )

= 1.2.4 =
* Fixed bugs concerning
 * Relatve date formats
 * Child-theme templates
 * Localisation
 * Calendar shortcode on php5.2

= 1.2.3 =
* Corrected potential 'class does not exist' bug

= 1.2.2 =
* Event list shortcode, `[eo_events]`, now supports templates which can be enclosed in the shortcode. [See the documenation](http://www.harriswebsolutions.co.uk/event-organiser/documentation/shortcodes/event-list-shortcode/).
* `eo_get_events` and the event list shortcode now support relative date formats for data parameters (e.g. `event_start_before='+1 week',`event_end_after='now'`). [See the documenation](http://www.harriswebsolutions.co.uk/event-organiser/documentation/relative-date-formats/).
* `eo_format_date` now supports relative date formats
* Added `eo_get_category_color` function.
* Added German and Spanish translations
* Fixed PHP 5.2 related bugs affecting calendars and events export
* Fixed event permissions bug
* Fixed other minor bugs reported here

= 1.2.1 =

* Fixed permalink bug
* Venue map marker can be manually dragged to a specific location
* Event Organiser is now compatible with PHP 5.2+
* Fixed minor calendar icon bug in IE

= 1.2 =
* Public events feed
* Delete individual occurrences
* Color-coded event categories
* Event tags
* (Optionally) automatically delete expired events
* Custom permalink structure
* Added `eo_subscribe` shortcode to create a subscribe link
* Agenda widget 
* Venue descriptions now support shortcodes
* Custom navigation menu title for events
* Option to decide when event is past
* Show all occurrences of an event or 'group occurrences'
* Improved user-interface
* Added template functions: `eo_get_the_occurrences`, `eo_get_the_venues`, `eo_event_venue_dropdown`, `eo_event_category_dropdown`, `eo_is_allday`, `eo_get_the_GoogleLink`, `eo_get_events_feed`. See [template functions documentation](http://www.harriswebsolutions.co.uk/event-organiser/documentation/function-reference/)
* Localisation (currently translations for French and Portugese (Brazil) are included)
* Improved default templates
* Fixed bugs [reported here](http://www.harriswebsolutions.co.uk/event-organiser/forums/forum/bugs/)

= 1.1.1 =
A minor update, fixing a few bugs and improving the (admin and public) calendars' performance. The bug which meant calendars and the calendar widget couldn't be displayed together is now fixed. For a full list of alterations [see here](http://www.harriswebsolutions.co.uk/event-organiser/uncategorized/2012/bug-fixing-update-due-1-1-1/).

= 1.1 =
Improved admin calendar navigation, with category/venue filters. Public version of the 'admin calendar' now available as a shortcode. You can now import events from an ICAL file. Further details included in the ics export file. The venue content editor is now fully featured. Venue descriptions now understand shortcodes. Fixed a few bugs.

= 1.0.5 =
Fixed export bug.

= 1.0.4 =
Introduced warning messages for unsupported PHP / WP versions and missing tables. Updated templates to work with more themes. Updated event table install.

= 1.0.3 =
Fixed 'blank screen of death' for unsupported versions (WP < 3.3). The plug-in will still not operate correctly for versions before 3.3.

= 1.0.2 =
Fixed ics exporter and deactivation/uninstall

= 1.0.1 =
Minor bug fixes and readme update.

= 1.0.0 =
Initial release

== Upgrade Notice ==
= 1.3.2 =
This fixes permalink bug introduced in 1.3.1. If you upgraded to 1.3.1, you should upgrade to 1.3.2. You're advised to 'flush rewrite rules' by simplying visiting your permalinks setting page.

= 1.3 =
This a fairly big update and includes converting venues into a custom taxonomy. As a result some venue slugs *may* change. See the [plug-in website](http://www.harriswebsolutions.co.uk/event-organiser/uncategorized/2012/whats-new-in-1-3/) for more details.

= 1.0.4 =
The templates have been adapted to work as is in for more themes. Error messages now display for unsupported versions.
