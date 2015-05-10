<?php
/**
 * Template Name:開始日順
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents">
	<?php get_sortarea(); ?>
	<?php
		$query = array('post_type' => 'post',
					'posts_per_page' => '-1',
					'orderby' => 'meta_value',
					'meta_key' => 'wpcf-start_date',
					'order' => 'ASC'
					);
		$rand_posts = get_posts($query);
	?>
	<?php if(empty($rand_posts)){echo "表示できるデータがありません。";}?>
	<?php foreach( $rand_posts as $post ) : ?>
		<?php if(is_current_data() === false){continue;} ?>
		<?php get_loop_item($post); ?>
	<?php endforeach; ?>
</div>
<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>