<?php
/**
 * Template Name:人気順
 */
  get_header(); ?>
<div id="main">
<div id="contents">
<?php get_sortarea(); ?>

<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&orderby=date');

if ( have_posts() ){
	$cnt = 0;
	foreach( $rand_posts as $post ){
		$source_url = "http://cosarin.com/";

		$get_facebook = 'http://api.facebook.com/restserver.php?method=links.getStats&urls=' . $source_url;
		$xml = file_get_contents($get_facebook);
		$xml = simplexml_load_string($xml);
		$likes = $xml->link_stat->like_count;//いいね！数。※シェア数ならshare_countで

		$get_twitter = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $source_url;
		$json = file_get_contents($get_twitter);
		$json = json_decode($json);
		$tweets = $json->{'count'};//ツイート数

		$hatena_json_uri = 'http://b.hatena.ne.jp/entry/json/?url='.rawurlencode($source_url);
		$result = file_get_contents( $hatena_json_uri );
		$hatena_result_array = json_decode($result);
		$hatena = $hatena_result_array->count;

		$post -> fav = ( $likes + $tweets . $hatena ) - $cnt;
		$sort[] = ( $likes + $tweets . $hatena ) - $cnt;
		$cnt++;
	}
}

?>
	<?php if ( have_posts() ) : ?>
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
			?>

			<?php
				$the_date = types_render_field("close_date", array());
				if ($the_date == ""):
					$the_date = types_render_field("start_date", array());
				endif;
				if (strtotime($the_date) >= strtotime(date_i18n("Y/m/d"))) :
			?>

				<article>
					<a class="nonu" href="<?php the_permalink(); ?>">
						<div class="icatch <?php echo $cat;?>">
						<span>
							<?php
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
							<?php echo(types_render_field("start_date", array())); ?>-<?php echo(types_render_field("close_date", array())); ?>
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
			<?php endif; ?>

		<?php endforeach; ?>
	<?php else : ?>
		表示できるデータがありません。
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>