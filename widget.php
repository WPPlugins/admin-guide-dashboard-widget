<?php
/**
 * This file could be used to catch submitted form data. When using a non-configuration
 * view to save form data, remember to use some kind of identifying field in your form.
 */
?>
<?php    
	/**
 *
 * Show custom post types in dashboard admin guide widget
 *
 */
   echo '<style>
			#admin-guide-widget {font-size: 1.2em; background: #84dcff; padding: 11px;}
			.activity-block a {color: #fff; font-weight: 700;}
			.activity-block a:hover {color: #000;}
			#footer {width: 100%}
			#footer td {width: 50%}
			#footer .even {text-align: right;}
		</style>';


	echo '<div id="admin-guide-widget" class="adminmenu">';

	GLOBAL $categoryid;
	$categoryid = self::get_dashboard_widget_option(self::wid, 'category_number');
	echo 'Category id is set as '.$categoryid;

/*	
	$query_args = array(
		'post_type'      => 'post',
		'cat'            => 46,
		'orderby'        => 'date',
		'no_found_rows'  => true,
		'cache_results'  => false
	);
	$posts = new WP_Query( $query_args );
*/
	$shivquery['post_type'] = 'post';
	$shivquery['cat'] = $categoryid;
	$shivquery['orderby'] = 'date';
	
	$posts = new WP_Query( $shivquery );
	
	if ( $posts->have_posts() ) {

		echo '<div class="activity-block">';
		echo '<ul>';

		$today    = date( 'Y-m-d', current_time( 'timestamp' ) );
		$tomorrow = date( 'Y-m-d', strtotime( '+1 day', current_time( 'timestamp' ) ) );

		while ( $posts->have_posts() ) {
			$posts->the_post();

			$time = get_the_time( 'U' );
			if ( date( 'Y-m-d', $time ) == $today ) {
				$relative = __( 'Today' );
			} elseif ( date( 'Y-m-d', $time ) == $tomorrow ) {
				$relative = __( 'Tomorrow' );
			} else {
				/* translators: date and time format for recent posts on the dashboard, see http://php.net/date */
				$relative = date_i18n( __( 'M jS' ), $time );
			}

			if ( current_user_can( 'edit_post', get_the_ID() ) ) {
				/* translators: 1: relative date, 2: time, 3: post edit link, 4: post title */
				$format = __( '<span style="margin-right: 11px;">%1$s, %2$s</span> <span class="dashicons dashicons-admin-post"></span> <a href="%5$s">%4$s</a> - <a href="%3$s">edit</a>' );
				printf( "<li>$format</li>", $relative, get_the_time(), get_edit_post_link(), _draft_or_post_title(), get_permalink() );
			} else {
				/* translators: 1: relative date, 2: time, 3: post title */
				$format = __( '<span>%1$s, %2$s</span> %3$s' );
				printf( "<li>$format</li>", $relative, get_the_time(), _draft_or_post_title() );
			}			
		}

		echo '</ul>';
		echo '</div>';

	} 

	wp_reset_postdata();

	echo '<p><span class="dashicons dashicons-pressthis"></span>Note :- You can relocate/place this widget any where by drag and drop</p>
	<p><span class="dashicons dashicons-pressthis"></span>Note :- Hover mouse over title "Administration Guide" link for configuration/setting widget for category will be visible.</p>
	';

	echo '</div><table id="footer"><tr>
	<td><small>Dashboard plugin developer - <a href="http://itweb.in/web-designer-shivcharan-patil/">Shivcharan Patil</a>.</small></td>
	<td class="even">Like it. Please support and <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=shivcharan%40itapplication.net&item_name=Buy%20a%20drink%20for%20developer%20via%20Paypal">Donate</a>.</td>
	</tr></table>
	';
