<?php
/**
 * Template Name:x
 */
?>
<?php if ( is_home()) { ?>

	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&orderby=date'); ?>

<?php } elseif (is_page('regorder')) { ?>

	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&orderby=date'); ?>

<?php } elseif (is_search()) { ?>

	<?php
		global $query_string;
		query_posts($query_string . "&post_type=post");
	?>

<?php } elseif (is_author()) { ?>

	<?php $rand_posts = query_posts('author=' .$author_id .'&post_type=post&posts_per_page=-1'); ?>

<?php } elseif (is_page('startorder')) { ?>

	<?php
		$query = array('post_type' => 'post',
					'posts_per_page' => '-1',
					'orderby' => 'meta_value',
					'meta_key' => 'wpcf-start_date',
					'order' => 'ASC'
					);
		$rand_posts = get_posts($query);
	?>

<?php } elseif (is_page('kako')) { ?>

	<?php $rand_posts = get_posts('post_type=post&posts_per_page=-1&order=ASC&orderby=meta_value&meta_key=wpcf-start_date'); ?>

<?php } elseif (is_archive()) { ?>

<?php } else { ?>
<?php } ?>
	<?php if(empty($rand_posts)){echo "表示できるデータがありません。";}?>
	<?php foreach( $rand_posts as $post ) : ?>
		<!-- カテゴリーのクラス取得、優先順art>tech>other どれでもなければ'other' -->
		<?php if (is_page('kako')) { //過去ページ判別スタート ?>
			<?php if(is_past_data() === false){continue;} ?>
			<?php get_loop_item($post); ?>
		<?php } else { ?>
			<?php if(is_current_data() === false){continue;} ?>
			<?php get_loop_item($post); ?>
		<?php } //過去ページ判別エンド ?>
	<?php endforeach; ?>