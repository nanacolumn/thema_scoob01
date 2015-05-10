<?php
/**
 * Template Name:投稿者の記事一覧
 */
?>
<?php get_header(); ?>
<div id="main">
<div id="contents_view">
	<div id="archive_title">
		<?php $author = get_userdata($post->post_author);
			$author_id = $author->ID;
			echo $author->display_name;
		?>の投稿記事一覧
	</div>
	<?php $rand_posts = query_posts('author=' .$author_id .'&post_type=post&posts_per_page=-1'); ?>
	<?php if(empty($rand_posts)){echo "表示できるデータがありません。";}?>
	<?php foreach( $rand_posts as $post ) : ?>
		<?php get_loop_item($post); ?>
	<?php endforeach; ?>
</div>
<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
</div>
</div>
<?php get_footer(); ?>