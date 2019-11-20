<?php 
/*template name: Contact*/
get_header();

require_once 'custom-inner-page-advertisement.php';

?>

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
		</div>
	</div>
</div>


        <div class="main-content">
            <div class="container">
                <div class="contact-container">
                    <h1>Contact Us</h1>
                <div class="category-box-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="contact-box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="contact-support">
                                                <h3>Contact Us Today</h3>
                                                <div class="contact-respond">We will respond within 24 hours!</div>
                                                <ul>
                                                    <li>
                                                        <span><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/call-support.png" alt="Contact"></span>
                                                        <span><b>Live Support Chat</b> Bottom Right Of Every Page</span>
                                                    </li>
                                                    <li>
                                                        <span><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/call-icon.png" alt="Contact"></span>
                                                        <span><b>Live Support Chat</b> Bottom Right Of Every Page</span>
                                                    </li>
                                                    <li>
                                                        <span><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/mail.png" alt="Contact"></span>
                                                        <span><b>Live Support Chat</b> Bottom Right Of Every Page</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="contact-support">
                                                <?php 
                                                echo do_shortcode('[contact-form-7 id="79693" title="Contact form 1"]');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="contact-map">
                                               <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12538.969891940234!2d-122.1360457!3d38.2158752!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6ce905edaf329d4c!2sDirect+Diesel+Inc.!5e0!3m2!1sen!2sin!4v1558596501230!5m2!1sen!2sin" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                    echo do_shortcode('[custom_get_product_category_by_slug_shortcode cate_slug="ford" cat_id="44" title="MOST POPULAR - POWERSTROKE" title2="SHOP POWERSTROKE"]');
                                ?>
                            </div>
                        </div>
                    </div><!--container-->
                </div><!--category-box-container-->
                </div><!--contact-container-->
            </div>
        </div><!--main-content-->

<?php get_footer(); ?>