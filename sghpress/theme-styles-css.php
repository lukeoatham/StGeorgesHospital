<style type="text/css">
<?php $options = get_option( 'commentariatGOVUK_theme_options' ); ?>

h1, h2, h3, h4, h5, h6, #primarynavmenu a, .promo a:hover, .promo a:active, a:link, .promo a:hover, .promo a:active {
	color: #<?php echo $options['headercolour']; ?>;
}

.metabox, .jumptocomments {
	background-color: #<?php echo $options['boxcolour']; ?>;
}

.leftpromo {
	border-color: #<?php echo $options['headercolour']; ?>;
}

.middlepromo {
	border-color: #<?php echo $options['headercolour']; ?>;
}

.rightpromo {
	border-color: #<?php echo $options['headercolour']; ?>;
}


</style>