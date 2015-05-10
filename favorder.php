<?php
/**
 * Template Name:人気順
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents">
	<?php get_sortarea(); ?>
	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&orderby=date');
	if(!empty($rand_posts)){
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