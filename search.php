<?php get_header(); ?>
<div id="main">
<div id="contents_view">

	<?php
		global $query_string;
		query_posts($query_string . "&post_type=post");
	?>
	<?php if (have_posts()) : ?>
	<div id="archive_title">"<?php echo wp_specialchars($s, 1); ?>"の検索結果 <?php echo $wp_query->found_posts; ?> 件</div>
	<?php while (have_posts()) : the_post(); ?>
			
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
				if (in_category('kyoto')) :
					$cat_area = 'kyoto';
				elseif (in_category('osaka')) :
					$cat_area = 'osaka';
				elseif (in_category('hyogo')) :
					$cat_area = 'hyogo';
				elseif (in_category('area-other')) :
					$cat_area = 'area-other';
				else :
					$cat_area = 'area-other';
				endif;
			?>
				<article>
					<a class="nonu" href="<?php the_permalink(); ?>">
						<div class="icatch heightLine <?php echo $cat.' '.$cat_area;?>">
							<span><?php
								if ("" == get_post_meta($post->ID, 'wpcf-eyecatch', true)) :
									if ($cat == 'art') : ?>
										<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_art.jpg" alt="dummy_art" width="196" height="146" />
									<?php elseif ($cat == 'tech') : ?>
										<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_tech.jpg" alt="dummy_tech" width="196" height="146" />
									<?php elseif ($cat == 'other') : ?>
										<img src="<?php echo get_stylesheet_directory_uri() ?>/images/dummy_other.jpg" alt="dummy_other" width="196" height="146" />
									<?php endif; ?>
							<?php else : ?>
								<?php echo(types_render_field("eyecatch", array("width"=>"196","height"=>"146","proportional"=>"true"))); ?>
							<?php endif; ?>
							</span>
							<h1>
								<?php
									$title = the_title('', '', false);
									echo mb_strimwidth($title, 0, 44, "...", 'UTF-8');
								?>
							</h1>
						</div>
					</a>
					<div class="top_text">
						<time>
							<?php echo(types_render_field("start_date", array('format'=>'Y.m.d D'))); ?>-<?php echo(types_render_field("close_date", array('format'=>'Y.m.d D'))); ?>
						</time>
						<p>
							<?php
								$content = $post->post_content;
								echo mb_strimwidth($content, 0, 180, "...", 'UTF-8');
							?>
							<a href="<?php the_permalink(); ?>">続きを見る</a>
						</p>
					</div>
				</article>
		<?php endwhile; ?>

	<?php else : ?>
		表示できるデータがありません。
	<?php endif; ?>

</div>

<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>