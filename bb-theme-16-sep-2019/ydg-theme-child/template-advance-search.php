<?php 
/*template name: Advance Search Template*/
get_header(); ?>
<div class="fl-content-full container">
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
			<div class="advance-search-temp">
			<?php
                the_widget( 'Pektsekye_Ymm_Widget_HorizontalSelector', 'title= ' );
                //the_widget( 'Pektsekye_Ymm_Widget_Selector', 'title= ' );
            ?>
            </div>
    		</div>
	</div>
</div>
<?php get_footer(); ?>