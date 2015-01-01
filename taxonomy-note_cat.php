<?php get_header(); ?>

<div id="main">
<div id="blog-contents">
	<h2 class="cat-archive"><?php single_cat_title('カテゴリー： '); ?></h2>
	<?php get_template_part('post'); ?>
</div>
<?php get_template_part('sidebar-2'); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>