<?php
/* Template name: Home page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="sevencol">
					<?php the_content(); ?>
					<h2>Carousel</h2>
					St George’s Healthcare provides diagnosis, surgery and chemotherapy for all types of cancer as well as palliative care (care to improve quality of life) and follow-up clinics. It also plays a key part in cancer prevention, offering screening services and treatment for pre-cancer stages. Radiotherapy (using x-rays or other forms of radiation as treatment) for patients is provided at the Royal Marsden Hospital with which St George’s Healthcare is a Joint Cancer Centre. There is close liaison with primary healthcare teams and local hospices to provide seamless care for cancer patients. A 24-hour on-call oncology and palliative care service is available.
					</div>
					
					<div class="fivecol last">
						<h2>News</h2>
						St George’s Healthcare provides diagnosis, surgery and chemotherapy for all types of cancer as well as palliative care (care to improve quality of life) and follow-up clinics. It also plays a key part in cancer prevention, offering screening services and treatment for pre-cancer stages. Radiotherapy (using x-rays or other forms of radiation as treatment) for patients is provided at the Royal Marsden Hospital with which St George’s Healthcare is a Joint Cancer Centre. There is close liaison with primary healthcare teams and local hospices to provide seamless care for cancer patients. A 24-hour on-call oncology and palliative care service is available.
					</div>

				</div>
				<div class="row">

					<div class="sevencol">
						<div class="fourcol">
							<h2>Box 1</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
						<div class="fourcol">
							<h2>Box 2</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
						<div class="fourcol last">
							<h2>Box 3</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
					</div>
					
					<div class="fivecol last">
						<div class="sixcol">
							<h2>Box 4</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
						<div class="sixcol last">
							<h2>Box 5</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
					</div>

				</div>
				<div class="row">

					<div class="sevencol">
						<div class="fourcol">
							<h2>Box 6</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
						<div class="fourcol">
							<h2>Box 7</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
						<div class="fourcol last">
							<h2>Box 8</h2>
							<img src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
					</div>
					
					<div class="fivecol last">
						<div class="twelvecol last">
							<h2>Box 9</h2>
							<img style="width:100%;" src='http://sgh.helpfulclients.com/wp-content/uploads/2013/05/file0001491377628-150x150.jpg' />
						</div>	
					</div>

				</div>

				

		
				

<?php endwhile; ?>

<?php get_footer(); ?>