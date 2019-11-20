<?php

/*
Template Name: Front page


*/

get_header();

?>

<div class="container main-container front-page">
	<div class="row">
		<div class="col-md-12">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'content', 'page' );
				endwhile;
			endif;
			?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
