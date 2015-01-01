<?php get_header(); ?>

<div id="main">
<div id="contents">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php
		$start_date = get_post_meta($post->ID, 'wpcf-start_date', true);
		$close_date = get_post_meta($post->ID, 'wpcf-close_date', true);
		$start_time = get_post_meta($post->ID, 'wpcf-start_time', true);
		$close_time = get_post_meta($post->ID, 'wpcf-close_time', true);
		$time_biko = get_post_meta($post->ID, 'wpcf-time_biko', true);
		$price = get_post_meta($post->ID, 'wpcf-price', true);
		$eyecatch = get_post_meta($post->ID, 'wpcf-eyecatch', true);
		$url = get_post_meta($post->ID, 'wpcf-url', true);
		$place_name = get_post_meta($post->ID, 'wpcf-place_name', true);
		$address = get_post_meta($post->ID, 'wpcf-address', true);
		$access_biko = get_post_meta($post->ID, 'wpcf-access_biko', true);
	?>
	<?php
	//カレンダーに登録のurlを生成します。
	$date = date('Ymd', $start_date) . "T" . date( 'His', strtotime( date('Y-m-d') . $start_time . '-9 hour')) . "Z";
	if( $close_date != ""){
		$date .= "/" . date('Ymd', $close_date) . "T" . date( 'His', strtotime( date('Y-m-d') . $close_time . '-9 hour')) . "Z";
	}

	$calendar_url = "";
	$calendar_url .= "https://www.google.com/calendar/render?action=TEMPLATE";
	$calendar_url .= "&text=" . urlencode( the_title('','',false) );
	$calendar_url .= "&dates=" . urlencode( $date );
	$calendar_url .= "&details=" . urlencode( $url );
	$calendar_url .= "&location=" . urlencode( $address );
	$calendar_url .= "&trp=false";
	//$calendar_url .= "&sprop=" . urlencode( $the_title );
	//$calendar_url .= "&sprop=name:" . urlencode( $url );
	$calendar_url .= "&sf=true&output=xml";

	?>
	
	<?php
		if (in_category('design')) :
			$cat = 'art';
		elseif (in_category('tech')) :
			$cat = 'tech';
		elseif (in_category('others')) :
			$cat = 'other';
		else :
			$cat = 'other';
		endif;
	?>


	<div class="detail">
	<h3 class="shadow shadow<?php echo $cat; ?>"><?php the_title(); ?></h3>
	<h4 class="leftBoder leftBoder<?php echo $cat; ?>">DETAIL</h4>
	<table>
		<tr>
			<th>開催日時</th>
			<td><time>
				<?php echo(types_render_field("start_date", array('format'=>'Y.m.d D'))); ?>
				<?php if("" != $close_date) : ?>
					-<?php echo(types_render_field("close_date", array('format'=>'Y.m.d D'))); ?>
				<?php endif; ?>
				<?php if("" != $start_time) : ?>
					<br><?php echo $start_time; ?>
				<?php endif; ?>
				<?php if("" != $close_time) : ?>
					-<?php echo $close_time; ?>
				<?php endif; ?>
				<?php if("" != $time_biko) : ?>
					<br><?php echo $time_biko; ?>
				<?php endif; ?>
			</time></td>
		</tr>
		<?php if("" != $price) : ?>
		<tr>
			<th>参加費</th>
			<td><?php echo $price; ?></td>
		</tr>
		<?php endif; ?>
		<?php if("" != $place_name || "" != $address) : ?>
		<tr>
			<th>開催場所</th>
			<td>
				<?php if("" != $place_name) : ?>
					<?php echo $place_name; ?><br>
				<?php endif; ?>
				<?php if("" != $address) : ?>
					<?php echo $address; ?><br>
					<a href="http://maps.google.co.jp/maps?q=<?php echo $address; ?>" target="_blank">GoogleMapへ</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if("" != $access_biko) : ?>
		<tr>
			<th>備考</th>
			<td><?php echo $access_biko; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if("" != $url) : ?>
		<tr>
			<th>詳細URL</th>
			<td>
				<a href="<?php echo $url ?>" target="_blank">
					<?php echo $url ?>
				</a>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th>シェア</th>
			<td>
				<div class="facebook_like"></div>
				<div class="twitter"></div>
				<div class="hatena"></div>
				<div class="google_plusone"></div>
				<div class="rss"><a href="<?php echo esc_url( home_url( '/' ) ); ?>feed"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/rss.gif" alt="rss" width="50" height="46" /></a></div>
				<div class="addcal"><a href="<?php echo $calendar_url; ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/cal.gif" alt="cal" width="120" height="46" /></a></div>
			</td>
		</tr>
	</table>

	<div class="rightBox">
		<div class="image<?php echo $cat; ?>">
		<?php if("" != $url) : ?>
			<a href="<?php echo $url ?>" target="_blank">
		<?php endif; ?>
		<?php
			if ("" == get_post_meta($post->ID, 'wpcf-eyecatch', true)) :
				if ($cat == 'art') : ?>
					<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_art.jpg" alt="dummy_art" width="196" height="146" />
				<?php elseif ($cat == 'tech') : ?>
					<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_tech.jpg" alt="dummy_tech" width="196" height="146" />
				<?php elseif ($cat == 'other') : ?>
					<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_other.jpg" alt="dummy_other" width="196" height="146" />
				<?php endif; ?>
		<?php else : ?>
			<?php echo types_render_field("eyecatch", array("width"=>"196","height"=>"146","proportional"=>"true")); ?>
		<?php endif; ?>
		<?php if("" != $url) : ?>
			</a>
		<?php endif; ?>
		</div>
		<p class="postName <?php the_author(); ?>">Post by <?php the_author_posts_link(); ?></p>
	</div>
	</div>

	<?php endwhile; // end of the loop. ?>
<div class="comment">
	<?php the_content(); ?>
</div>

<?php if("" != $address || "" != $access_biko ) : ?>
	<div class="access">
	<h4 class="leftBoder leftBoder<?php echo $cat; ?>">ACCESS</h4>
	<?php if("" != $place_name) : ?>
		<p><?php echo $place_name; ?></p>
	<?php endif; ?>
	<p><?php echo $address; ?></p>
	<p><?php echo $access_biko; ?></p>
	<div id="googlemap"></div>
	</div>
<?php endif; ?>

<div class="info">
<?php if("" != $url) : ?>
	<p class="siteLink"><a href="<?php echo $url; ?>" target="_blank">サイトを確認する</a></p>
<?php endif; ?>
<div id="share_bottom">
	<div class="facebook_like"></div>
	<div class="twitter"></div>
	<div class="hatena"></div>
	<div class="google_plusone"></div>
	<div class="rss"><a href="<?php echo esc_url( home_url( '/' ) ); ?>feed"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/rss.gif" alt="rss" width="50" height="46" /></a></div>
	<div class="addcal"><a href=""><img src="<?php echo get_stylesheet_directory_uri() ?>/images/cal.gif" alt="cal" width="120" height="46" /></a></div>
</div>
<p class="attention">掲載情報は<?php the_modified_date(); ?>現在のものです。<br>
現在の内容と異なる場合がありますので、あらかじめご了承ください。</p>

</div>


</div>

<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>