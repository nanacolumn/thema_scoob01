<?php
/**
 * Template Name:その日のイベント
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents">
<div id="archive_title">
<?php
	//指定日のymd
	$this_date = $_GET['date'];

	echo date('Y/m/d', strtotime($this_date))."に開催中のイベント";

?>
</div>
<?php
	//開始日順で表示
	$rand_posts = get_posts('post_type=post&posts_per_page=-1&order=ASC&orderby=meta_value');
?>
	<?php if(empty($rand_posts)){echo "表示できるデータがありません。";}?>
	<?php foreach( $rand_posts as $post ) : ?>
		<!--start_date<=this_date<=close_date-->
		<?php

			//変数の初期化
			$start_date = "";
			$close_date = "";
			$start_ymd = "";
			$close_ymd = "";

			//開始日と終了日の取得
			$start_date = get_post_meta($post->ID, 'wpcf-start_date', true);
			$close_date = get_post_meta($post->ID, 'wpcf-close_date', true);

			//開始日は必須
			$start_ymd = date('Ymd', (int)$start_date);
			//終了日が入力されていれば
			if( $close_date != false ){
				$close_ymd = date('Ymd', (int)$close_date);
			}
		?>
		<?php
			//(終了日が入力されていないかつ開始日が指定日と同じ) または（終了日が入力されているかつ開始日が指定日より前かつ終了日が指定日より後）
			if( ($close_date == false && $start_ymd == $this_date ) || ( $close_date == true && $start_ymd <= $this_date && $this_date <= $close_ymd)) : ?>
			<?php get_loop_item($post); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>