<?php
/**
 * Template Name:過去アーカイブページ
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents_view">
<div id="archive_title">過去のイベント</div>
	<!--開始日順で表示 -->
	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&order=ASC&orderby=meta_value&meta_key=wpcf-start_date'); ?>
	<?php if(empty($rand_posts)){echo "表示できるデータがありません。";}?>
	<?php foreach( $rand_posts as $post ) : ?>
		<!--過去イベントを表示-->
		<?php if(is_past_data() === false){continue;} ?>
		<?php get_loop_item($post); ?>
	<?php endforeach; ?>
</div>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>