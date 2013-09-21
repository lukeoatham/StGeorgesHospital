<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="input-prepend input-append">
    	<label class="screen-reader-text hidden-phone add-on" for="s">Search:</label>
        <input type="text" value="<?php
        if(is_search()){
	        echo $_GET["s"];
        }
         ?>" name="s" id="appendedPrependedInput" class="searchbox twelvecol"  />
         <button class="tbn" type="button"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search.svg" alt="Search"></button>
        <!-- <input type="submit" id="searchsubmit" value="Search" /> -->
    </div>
</form>