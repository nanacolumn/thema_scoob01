					<?php while ( have_posts() ) : the_post(); ?>
						<article class="post_box">
							<header class="post_meta">
								<section class="date"><span><?php the_time('Y.m.d'); ?></span></section>
								<?php if(is_single()) { ?>
									<h1 class="post_title"><?php the_title(); ?></h1>
								<?php } else { ?>
									<h1 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
								<?php } ?>
								<p class="category">CATEGORY:</p>
								<ul class="post_cat">
									<?php echo  get_the_term_list( $post->ID, 'note_cat', '<li>', '</li><li>' , '</li>' , '' ); ?>
								</ul>
								<br>
								<p class="category">AUTHOR:<?php the_author(); ?></p>
							</header>
							<div class="post"><?php the_content('<span class="more">more...<img src="'.get_stylesheet_directory_uri().'/images/more.gif"></span>'); ?></div>
							<section id="socialbox_single">
								<ul class="clearfix">
									<li id="tweetbox">
										<a href="https://twitter.com/share" class="twitter-share-button"
										data-text="「<?php the_title(); ?>」«scoob.info"
										data-via="ScoobInfo"
										data-lang="ja"
										data-count="none">
										Tweet
										</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									</li>
									<li id="fbbox">
										<fb:like layout="button_count" show_faces="false" send="false"></fb:like>
										<div id="fb-root"></div>
											<script>
												(function(d, s, id) {
													var js, fjs = d.getElementsByTagName(s)[0];
													if (d.getElementById(id)) return;
													js = d.createElement(s); js.id = id;
													js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=253866034730523";
													fjs.parentNode.insertBefore(js, fjs);
												}(document, 'script', 'facebook-jssdk'));
											</script>
									</li>
									<li id="hatebubox">
										<a href="http://b.hatena.ne.jp/entry/<?php $str = get_bloginfo('url') . get_permalink(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="「<?php the_title(); ?>」«scoob.info" data-hatena-bookmark-layout="standard" title="このブログを追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このブログをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
									</li>
									<li id="googleplusbox"><!-- このタグを +1 ボタンを表示する場所に挿入してください -->
									<g:plusone size="medium"></g:plusone>
									<!-- この render 呼び出しを適切な位置に挿入してください -->
									<script type="text/javascript">
									  window.___gcfg = {lang: 'ja'};
									  (function() {
									    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
									    po.src = 'https://apis.google.com/js/plusone.js';
									    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script></li>
								</ul>
							</section><!-- /#socialbox_single -->
						</article>
					<?php if(is_single()) { ?>
						<nav class="post_nav_box">
							<div class="previous"><?php previous_post_link('%link','<span>PREV</span>'); ?></div>
							<div class="top"><a href="<?php echo esc_url( home_url( '/' ) ); ?>note">BLOG TOP</a></div>
							<div class="next"><?php next_post_link('%link','<span>NEXT</span>'); ?></div>
						</nav>
					<?php } ?>
					<?php endwhile; // end of the loop. ?>
					<?php if(!is_single()) { ?>
						<nav class="post_nav_box">
							<div class="previous"><?php next_posts_link('<span>PREV</span>'); ?></div>
							<div class="top"><a href="<?php echo esc_url( home_url( '/' ) ); ?>note">BLOG TOP</a></div>
							<div class="next"><?php previous_posts_link('<span>NEXT</span>'); ?></div>
						</nav>
					<?php } ?>