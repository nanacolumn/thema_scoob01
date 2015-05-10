<?php
/**
 * Template Name:アーカイブページ
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents">
	<?php get_sortarea(); ?>
	<?php if(have_posts() === false){echo "表示できるデータがありません。";}?>
	<?php while(have_posts()):the_post(); ?>
		<?php if(is_current_data() === false){continue;} ?>
		<?php get_loop_item($post); ?>
	<?php endwhile; ?>
</div>
<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>