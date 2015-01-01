<?php
/**
 * Template Name:その日のイベント
 */
 get_header(); ?>
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
	<?php if ( have_posts() ) :
		$i == 0;
	?>
		<?php foreach( $rand_posts as $post ) : ?>

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

				//(終了日が入力されていないかつ開始日が指定日と同じ) または（終了日が入力されているかつ開始日が指定日より前かつ終了日が指定日より後）
				if( ($close_date == false && $start_ymd == $this_date ) || ( $close_date == true && $start_ymd <= $this_date && $this_date <= $close_ymd)) :

					//表示件数取得
					$i = $i+1;

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
								echo mb_strimwidth(strip_tags($content), 0, 180, "...", 'UTF-8');
							?>
							<a href="<?php the_permalink(); ?>">続きを見る</a>
						</p>
					</div>
				</article>

			<?php endif; ?>
		<?php endforeach; ?>

		<div class="nodata">
		<?php if ($i == 0) :
				echo "該当するイベントはありません。";
			endif;
		?>
		</div>
	<?php else : ?>
		表示できるデータがありません。
	<?php endif; ?>

</div>
<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>