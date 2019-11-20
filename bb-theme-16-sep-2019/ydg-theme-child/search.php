<?php get_header(); ?>
<style>
.serchtitle a {font-size: 20px;margin-bottom: 10px;display: block;}.serchcont {display: block;margin-bottom: 20px;border-bottom: 2px solid #c0c0c0;padding-bottom: 10px;}
.fl-archive-nav-prev, .fl-archive-nav-next {display: inline-block;}
.fl-archive-nav-next{margin-left: 20px;}
</style>
<div class="container">
    <div class="row">

       		<div class="col-sm-12"><?php //FLTheme::archive_page_header(); ?></div>

			<?php if ( have_posts() ) : ?>

				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="row search-row">
					<?php if(has_post_thumbnail()){?>
					<div class="col-sm-2">
					    <span class="custom_deisel_thumbnail">
					        <a href="<?php echo get_permalink(get_the_ID());?>">
					            
					              <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>" /> 
					        </a>
					   </span>
					</div>
					<?php }?>
						<?php if(has_post_thumbnail()){?>
					    <div class="col-sm-10">
					        	<?php } else { ?>
					        	<div class="col-sm-12">
					        	    <?php } ?>
					     <div class="serchtitle">
					         <a href="<?php echo get_permalink(get_the_ID());?>"><?php the_title();?></a>
					     </div>
					     <div class="serchcont">
					         <?php if(substr(strip_tags(strip_shortcodes(get_the_content())),0,400)!=''){echo substr(strip_tags(strip_shortcodes(get_the_content())),0,400).'...';}
					               else{ echo strip_tags(strip_shortcodes(get_the_content())); }?>
					     </div>
					     
					     <?php
					     $get_post_type = get_post_type(get_the_ID());
					     
					     if($get_post_type == 'product'){  //echo $get_post_type;?>
					     
					      <div class="view-product-item">
					         <a href="<?php echo get_permalink(get_the_ID());?>">
					              View Product
					        </a>
					     </div>
					         
					    <?php  }
					     ?>
					     
					    
					     
					     </div>
					     
					     
					     
					   </div>
				<?php endwhile; ?>

				<div style="clear: both;display: block;width: 100%;margin-left: 15px;margin-bottom: 20px;"><?php FLTheme::archive_nav(); ?></div>

			<?php else : ?>

				<?php get_template_part( 'content', 'no-results' ); ?>

			<?php endif; ?>

</div>
</div>
<?php get_footer(); ?>