<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="input-prepend input-append">
    	<label class="screen-reader-text hidden-phone add-on" id="searchLabel" for="s">Search:</label>
        <input type="text" value="<?php
        if(is_search()){
	        echo $_GET["s"];
        }
         ?>" name="s" id="appendedPrependedInput" class="searchbox twelvecol" aria-labelledby="searchLabel" />
         <button class="btn searchButton" type="submit" role="button" aria-pressed="false" aria-controls="appendedPreprendedInput" tabindex="0" aria-labelledby="searchLabel">
	         <script type="text/javascript">
				var imageURL = "<?php echo get_stylesheet_directory_uri(); ?>/images/search";
				if (Modernizr.svg){
					jQuery(".searchButton").html("<img src=\"" + imageURL + ".svg\" alt=\"Search\">");
				}else{
					
					jQuery(".searchButton").html("<img src=\"" + imageURL + ".gif\" alt=\"Search\">");
				}
			</script>
			<noscript><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search.gif" alt="Search"></noscript>
		</button>
    </div>
</form>