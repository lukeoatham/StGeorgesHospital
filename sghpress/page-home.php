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
				

<?php endwhile; ?>

<?php get_footer(); ?>