<?php
			require_once 'core/init.php';
			include 'includes/head.php';
			include 'includes/navigation.php';
			include 'includes/header.php';
?>
 <div id="pandor">
	<div class="featured-post-area">
			<div class="container">
					<div class="row">
						<?php
								include 'includes/postfirstone.php';
								include 'includes/postsecond.php';
						?>
					</div>
			</div>
	 </div>
 </div>
<script>
jQuery(window).scroll(function(){
	var vscroll = jQuery(this).scrollTop();
	jQuery('#logotext').css({
		"transform" : "translate(0px, "+vscroll/2+"px)"
	});
});
</script>
</body>
</html>
