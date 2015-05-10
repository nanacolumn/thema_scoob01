<?php
/**
 * Template Name:検索結果
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents_view">
	<?php
		global $query_string;
		query_posts($query_string . "&post_type=post");
	?>
	<div id="archive_title">"<?php echo wp_specialchars($s, 1); ?>"の検索結果 <?php echo $wp_query->found_posts; ?> 件</div>
	<?php if(have_posts() === false){echo "表示できるデータがありません。";}?>
	<?php while (have_posts()) : the_post(); ?>
		<?php get_loop_item($post); ?>
	<?php endwhile; ?>
</div>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>