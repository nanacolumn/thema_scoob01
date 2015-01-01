<?php get_header(); ?>

<div id="main">
<div id="contents" class="form">
	<?php while ( have_posts() ) : the_post(); ?>

	<?php endwhile; // end of the loop. ?>

	<div>
		<?php the_content(); ?>
	</div>
</div>

<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>