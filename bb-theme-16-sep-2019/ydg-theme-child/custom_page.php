<?php
/* Template Name: New Design*/
get_header();

require_once 'custom-inner-page-advertisement.php'; ?>
<div class="fl-content-full container newpages">
	<div class="row">
		<div class="fl-content col-md-12">
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
<?php get_footer();?>