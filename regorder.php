<?php
/**
 * Template Name:新着順
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents">
	<?php get_sortarea(); ?>
	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&orderby=date'); ?>
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