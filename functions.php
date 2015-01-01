<?php
ini_set( 'display_errors', 0 );

function image_custom($key, $width, $height) {
global $post;
$custom_field = get_post_meta($post->ID, $key, true);

if($custom_field) { //if the user set a custom field
echo '<img class="cfi" src="'.$custom_field.'" alt="" width="'.$width.'" height="'.$height.'" />';
}
else { //else, return
return;
}
}
/**
 * init_sessions()
 *
 * @uses session_id()
 * @uses session_start()
 */
function init_sessions() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'init_sessions');

add_action( 'wp_ajax_mkCalendar', 'mkCalendar' );
add_action( 'wp_ajax_nopriv_mkCalendar', 'mkCalendar' );

function mkCalendar(){

	if( $_REQUEST['btn'] != "" ){
		if( $_REQUEST['btn'] == 'prev' ){
			if( $_SESSION['month'] == 1 ){
				$_SESSION['year']--;
				$_SESSION['month'] = 12;
			}else{
				$_SESSION['month']--;
			}

		}else if( $_REQUEST['btn'] == 'next'){
			if( $_SESSION['month'] == 12 ){
				$_SESSION['year']++;
				$_SESSION['month'] = 1;
			}else{
				$_SESSION['month']++;
			}
		}
	}else{
		//カレンダー表示
		unset($_SESSION['year']);
		unset($_SESSION['month']);

		$_SESSION['year'] = date_i18n('Y');
		$_SESSION['month'] = date_i18n('m');
	}

	$last = date_i18n('t', mktime(0, 0, 0,$_SESSION['month'],1,$_SESSION['year']));
	$last_cnt = $last+1;
	$first_week = date_i18n('N', mktime(0, 0, 0,$_SESSION['month'],1,$_SESSION['year']));
	$last_week = date_i18n('N', mktime(0, 0, 0,$_SESSION['month'],$last,$_SESSION['year']));

	//祝日
	if( !isset($_SESSION['holidays']) || $_SESSION['holidays']['key'] != date_i18n('Ym') ){
		unset($_SESSION['holidays']);
		$_SESSION['holidays']['key'] = date_i18n('Ym');
		$_SESSION['holidays']['day'] = getHolidays();
	}

	$calendarArr = Array();

	$num = 0;
	$first_week_diff = $first_week-1;
	for( $i=0; $i<$first_week_diff; $i++ ){
		$calendarArr[$num] = "";
		$num++;
	}

	$day = 1;
	for( $i=1; $i<=$last; $i++ ){
		$calendarArr[$num] = sprintf('%02d', $day);
		$day++;
		$num++;
	}

	$last_week_diff = 7-$last_week;
	for( $i=0; $i<$last_week_diff; $i++ ){
		$calendarArr[$num] = "";
		$num++;
	}

	$table = '';

	for( $i=0; $i<count($calendarArr); $i++ ){
		$date = $_SESSION['year'] . sprintf('%02d', $_SESSION['month']) . $calendarArr["$i"];
		if( $i % 7 == 0 ){
			$table .= "<tr>";
		}

		if( ($i % 7) == 6 || $_SESSION['holidays']['day'][$date] != false ){
			$class = " class='sun'";
		}else{
			$class = "";
		}

		$table .= "<td";
		if( $calendarArr["$i"] != "" ){
			$table .= " id='" . $date . "'";
		}
		if( $class != "" ){
			$table .= $class;
		}
		$table .= "><a href='cal_list?date=" . $date . "'><span>" . $calendarArr["$i"] . "</span></a></td>";

		if( $i % 7 == 6 ){
			$table .= "</tr>";
		}
	}

	$data = Array();
	$data['table'] = $table;
	$data['month'] = $_SESSION['year'] . "/" . sprintf('%02d', $_SESSION['month']);
	$data['today'] = ($_POST['date'] != "")? $_POST['date']: date_i18n('Ymd');
	if( $_SESSION['year'].sprintf('%02d', $_SESSION['month']) > date_i18n('Ym') ){
		//prev表示
		$data['p'] = 1;
	}
	if( $_SESSION['year'].sprintf('%02d', $_SESSION['month']) < (date_i18n('Ym', strtotime('+2 month'))) ){
		//next表示
		$data['n'] = 1;
	}

	echo(json_encode($data));
	exit;
}

function getHolidays(){
	$ym01 = date_i18n('Y-m-01');
	$ymt = date_i18n('Y-m-t', strtotime($ym01 . '+2 month'));

	$holidays_url = sprintf(
        'http://www.google.com/calendar/feeds/%s/public/full-noattendees?start-min=%s&start-max=%s&max-results=%d&alt=json' ,
        'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com' , // 'japanese@holiday.calendar.google.com' ,
        $ym01 ,  // 取得開始日
        $ymt ,  // 取得終了日
        15              // 最大取得数
        );
	if ( $results = file_get_contents($holidays_url) ) {
        $results = json_decode($results, true);
        $holidays = array();
        foreach ($results['feed']['entry'] as $val ) {
                $date  = $val['gd$when'][0]['startTime'];
                $title = $val['title']['$t'];
                $holidays[date_i18n('Ymd', strtotime($date))] = 'holiday';
        }
	}

	return $holidays;
}

/* 開始日を数値としてorderbyする。*/
function my_orderby($orderby) {

	global $wpdb;

	if (get_query_var('meta_key') == 'wpcf-start_date') {
		$orderby = "CAST($wpdb->postmeta.meta_value AS UNSIGNED) ASC";
	}

	return $orderby;
}

add_filter('posts_orderby', 'my_orderby');


// 新規投稿ページの記事本文にデフォルト値をセットする
add_filter('default_content', 'default_content_filter');
function default_content_filter($post_content){
	global $typenow;
	if( $typenow == 'post' ){
		$post_content = "※ 画像及びテキストの著作権は引用元に帰属します。";
		return $post_content;
	}
}



/* エディタの見栄え調整 */
add_editor_style("editor-style.css");


/* pre_get_posts
*************************************************************** */
function customize_main_query ( $query ) {
    if ( ! is_admin() && $query->is_category() ) { // 管理画面以外 かつ メインクエリー
            $query->set( 'posts_per_page', '-1' );
    }
}
add_action( 'pre_get_posts', 'customize_main_query' ); // pre_get_postsにフック


/**
 * Load sortarea template.
 *
 * Includes the sortarea template for a theme or if a name is specified then a
 * specialised sortarea will be included.
 *
 * For the parameter, if the file is called "sortarea-special.php" then specify
 * "special".
 *
 * @uses locate_template()
 * @since 1.5.0
 * @uses do_action() Calls 'get_sortarea' action.
 *
 * @param string $name The name of the specialised sortarea.
 */
function get_sortarea( $name = null ) {
	do_action( 'get_sortarea', $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "sortarea-{$name}.php";

	$templates[] = 'sortarea.php';

	// Backward compat code will be removed in a future release
	if ('' == locate_template($templates, true))
		load_template( ABSPATH . WPINC . '/theme-compat/sortarea.php');
}

/* ウィジェット
*************************************************************** */
if (function_exists('register_sidebar')) {

register_sidebar(array(
 'name' => 'sidebar',
 'id' => 'widget01',
 ));
}

/* カスタムポストタイプ */
register_post_type(
	'note',
	array(
		'label' => 'ブログ',
		'hierarchical' => false,
		'public' => true,
		'query_var' => false,
		'menu_position' => 4,
		'has_archive' => true,
		'supports' => array('title','editor','author','thumbnail')
	)
);

/* カスタムタクソノミー */
add_action( 'init', 'create_my_taxonomies', 0 );
function create_my_taxonomies() {
    // ノートカテゴリ
    register_taxonomy(
        'note_cat',
        'note',
        array(
        	'has_archive' => true,
            'hierarchical' => true,
            'label' => 'カテゴリ',
            'query_var' => true,
            'rewrite' => true
        )
    );
}


?>