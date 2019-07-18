<script>
jQuery(window).scroll(function(){
	var vscroll = jQuery(this).scrollTop();
	jQuery('#logotext').css({
		"transform" : "translate(0px, "+vscroll/2+"px)"
	});
});
</script>
</div>
</body>
</html>
