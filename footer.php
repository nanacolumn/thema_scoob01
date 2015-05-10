<footer id="footer">
<div id="footerlogo">
<img src="<?php echo get_stylesheet_directory_uri() ?>/images/foot_logo.gif" width="138" height="64" alt="scoob from KANSAI">
</div>
<address>copyright <?php echo date_i18n("Y"); ?> Scoob all rights reserved.</address>
</footer>
</div><!-- #love -->
<script type="text/javascript">
//Googleアナリティクス
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-39433914-1']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
<?php wp_footer(); ?>
</body>
</html>