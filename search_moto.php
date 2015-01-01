<?php get_header(); ?>

<div id="main">
	<?php get_sidebar( ); ?>
	<div id="contents">

	<?php if (have_posts()) : ?>
		<div id="contents_head">
			<h1 id="default_page_title" class="fs16 bold">"<?php echo wp_specialchars($s, 1); ?>"の検索結果 <?php echo $wp_query->found_posts; ?> 件</h1>
			<div id="breadcrumb"><a href="/">HOME</a><span class="raquo">&raquo;</span>検索結果</div>
		</div>
		
		<?php 
			$paged = get_query_var('paged');
		?>
<?php while (have_posts()) : the_post(); ?>
			<div class="search_box">
				<h2 class="bold search_title fs12"><a href="<?php the_permalink(); ?>"><?php the_title();?> </a></h2>
			 	<p><?php the_excerpt(); ?></p>
			</div>
<?php endwhile; ?>
	

        <?php else: ?>    <!--  キーワードが見つからないときの処理 -->
		<div id="contents_head">
			<h1 id="default_page_title" class="fs16 bold">"<?php echo wp_specialchars($s, 1); ?>"の検索結果 <?php echo $wp_query->found_posts; ?> 件</h1>
			<div id="breadcrumb"><a href="/">HOME</a><span class="raquo">&raquo;</span>検索結果</div>
		</div>
			<div class="search_box">
            	<p>キーワードはみつかりません。</p>
			</div>
        <?php endif; ?>
						
				
		<div class="navigation mt30">
			<div class="left"><?php previous_posts_link('<&nbsp;前の検索結果'); ?></div>
			<div class="right"><?php next_posts_link('次の検索結果&nbsp;>'); ?></div>
		</div>
				
	</div><!-- /#contents -->
</div><!-- /#main -->

<?php get_footer(); ?>
		