<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<?php
	$title_detail = "";
	if(is_home() || is_page('redorder') || is_page('startorder')){
	}elseif(is_page('kako')){
		$title_detail = " | 過去のイベント";
	}elseif (is_page('about')){
		$title_detail = " | About";
	}elseif (is_page('contact')){
		$title_detail = " | Contact";
	}elseif (is_single()){
		$start_date = get_post_meta($post->ID, 'wpcf-start_date', true);
		$close_date = get_post_meta($post->ID, 'wpcf-close_date', true);
		$start_time = get_post_meta($post->ID, 'wpcf-start_time', true);
		$close_time = get_post_meta($post->ID, 'wpcf-close_time', true);
		$title_detail = " | ";
		$title_detail .= types_render_field("start_date", array('format'=>'Y.m.d (D)'));
		if("" != $close_date){
			$title_detail .= "-" .types_render_field("close_date", array('format'=>'Y.m.d (D)'));
		}
		$title_detail .= the_title();
	}
?>
<title>Scoob<?=$title_detail?></title>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<meta name="keywords" content="Webデザイナー, 関西, 大阪, 京都, 兵庫, 神戸, イベント, 勉強会, セミナー, デザイン, アート">
<meta name="description" content="【Scoob】関西のwebデザイナーのためのイベント情報発信サイト">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="all">
<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/base.css" media="all">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="http://maps.googleapis.com/maps/api/js?&sensor=false"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/socialbutton.js?1.9.1"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/heightLine.js"></script>
<script type="text/javascript">
$(function() {

	var topBtn = $('#page-top');
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 200) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});

	//スクロールしてトップ
	topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
	});

	//初期ロード時カレンダー作成
	var date = "<?php echo ( $_GET['date'] != FALSE)? $_GET['date']: "";  ?>";
	var ajaxurl = '<?php echo admin_url(); ?>' + 'admin-ajax.php';
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			"action": "mkCalendar",
			"date": date
		},
		success: function(data){
			var my_JSON = $.parseJSON(data);
			$('#prev a').hide();
			$('#calendar #month').empty().append(my_JSON.month);
			$('#calendar .table00').empty().append(my_JSON.table);
			$('#' + my_JSON.today).addClass('today');
			$('#calendar').fadeTo(100,1);
		},
		error: function(){
			$('#calendar').remove();
		}
	});

	//カレンダー
	$('#next a,#prev a').live('click',function(){
		$(this).hide();
		$('#calendar .table00').fadeTo(100,0);
		$('#calendar #month').fadeTo(100,0);
		btn = $(this).parent().attr('id');
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				"action": "mkCalendar",
				"date": date,
				"btn": btn
			},
			success: function(data){
				my_JSON = $.parseJSON(data);
				if( my_JSON.p == 1 ){
					$('#prev a').show();
				}else{
					$('#prev a').hide();
				}
				if( my_JSON.n == 1 ){
					$('#next a').show();
				}else{
					$('#next a').hide();
				}
				$('#calendar #month').empty().append(my_JSON.month).fadeTo(100,1);
				$('#calendar .table00').empty().append(my_JSON.table).fadeTo(100, 1);
				$('#' + my_JSON.today).addClass('today');
			},
			error: function(){
				$('#calendar .table00').fadeTo(100,1);
				$('#calendar #month').fadeTo(100,1);

			}
		});
		return false;
	});

	//SNSshare
	<?php $permalink = get_permalink(); ?>
	// Facebook / Like button
	$('.facebook_like').socialbutton('facebook_like', {
		button: 'button_count',
		show_faces: false,
		action: 'like',
		width: 110,
		height: 25,
		url: '<?php echo $permalink; ?>',
		colorscheme: 'light'
	});

	// Twitter / Tweet Button
	$('.twitter').socialbutton('twitter', {
		button: 'horizontal',
		url: '<?php echo $permalink; ?>',
		via: 'ScoobInfo',
		hashtags: 'ScoobInfo'
	});

	// Hatena / Hatena Bookmark
	$('.hatena').socialbutton('hatena', {
		url: '<?php echo $permalink; ?>'
	});

	// g+
	$('.google_plusone').socialbutton('google_plusone', {
		url: '<?php echo $permalink; ?>'
	});

	//外部サイトはtarget="_blank"
	var condition = '[href *="';
	condition += '<?php echo esc_url( home_url( '/' ) ); ?>';
	condition += '"]';
	$('a[href^=http]').not(condition).attr('target' , '_blank');

});

</script>

<?php if(is_single()) { ?>
	<?php while (have_posts()) : the_post(); ?>
		<meta property="og:title" content="<?php the_title(); ?> | <?php bloginfo('name'); ?>" />
		<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
		<meta property="og:url" content="<?php echo clean_url(get_permalink()); ?>" />
		<meta property="og:image" content="<?php echo get_post_meta($post->ID, 'wpcf-eyecatch', true); ?>" />
		<meta property="og:author" content="<?php the_author(); ?>" />
	<?php endwhile; ?>

<?php } else { ?>
	<meta property="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:url" content="<?php echo get_bloginfo('url') . $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:image" content="<?php echo get_bloginfo('template_directory') . '/ogp_default.jpg'; ?>" />
<?php } ?>

<meta property="og:site_name" content="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>" />
<meta property="og:type" content="blog" />
<meta property="fb:app_id" content="122089827978949" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

<?php wp_head(); ?>

<?php $gmap = get_post_meta($post->ID, 'wpcf-address', true);
	if ($gmap) { ?>
<script type="text/javascript">
	//googleMap
	//初期値：地図表示なし
	$(function() {
		$("div#googlemap").css("display", "none");
	});

	var g = new google.maps.Geocoder(),
		map, center ;
	g.geocode({
		'address': '<?php echo str_replace(array("\r\n","\n","\r"), '', $gmap); ?>'
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			//地図表示時はCSSのdisplay上書き
			$(function() {
				$("div#googlemap").css("display", "block");
			});

			center = results[0].geometry.location;
			var options = {
				center: center,
				zoom: 17,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: true,
				panControlOptions: {
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				zoomControlOptions: {
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				mapTypeControlOptions: {
					position: google.maps.ControlPosition.TOP_CENTER
				}
			};

			map = new google.maps.Map(document.getElementById('googlemap'), options);

			//上で取得した緯度経度でマーカー設置
			var marker = new google.maps.Marker({
				map: map,
				position: center
			});
		}
	});

if(0 >= $("#googlemap").size()){
}else{
}
</script>
<?php } else { ?>
<!--地図を使わない場合に何か処理したい場合はここに任意のコードを書きます-->
<?php } ?>
</head>
<body>
<div id="love">
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=561072070584081";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="wrap">
<header>
<div id="head" class="clearfix">
<hgroup>
<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.gif" height="74" width="189" alt="Scoob"></a></h1>
<p class="kansai">FROM KANSAI</p>
</hgroup>
<h2 id="catch">webデザイナーのためのデザイン&テクニカルのイベント情報発信サイトです</h2>
<nav>
<ul>
<li>
<?php if( 'note_cat' == get_post_type() || 'note' == get_post_type() || is_post_type_archive('note'))  : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>note/" class="current">
<?php else : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>note/">
<?php endif; ?>
	<span>BLOG</span></a></li>
<li>
<?php if(is_page('about') ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>about/" class="current">
<?php else : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>about/">
<?php endif; ?>
	<span>ABOUT</span></a></li>
<li>
<?php if(is_page('contact') ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>contact/" class="current">
<?php else : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>contact/">
<?php endif; ?>
	<span>CONTACT</span></a></li>
</ul>
</nav>
</div>
<div id="search">
<div id="shareBox">
<ul class="clearfix">
<li class="fb-like" data-href="http://scoob.info" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></li>
<li class="tw-button"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://scoob.info" data-text="webデザイナーのためのデザイン&テクニカルの情報発信サイト | Scoob" data-via="ScoobInfo" data-lang="ja" data-related="ScoobInfo" data-hashtags="ScoobInfo">ツイート</a><li>
</ul>
</div>
<div id="rss">
<a href="http://scoob.info/feed/"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ic_side_rss.gif" alt="rss" width="34" height="34" /></a>
</div>

<?php get_search_form(); ?>

</div>
<br class="clear_noie">
</header>