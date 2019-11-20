<?php
/*
* Custom Get Category By Slug
*/
function custom_countdown_timer_shortcode_function($atts){

     extract( shortcode_atts(
        array(
            'id' => '',
            'date' => '',
            'title'  => '',
            ), $atts )
    );
    ob_start();

?>
<div class="clock" style="margin:2em;"></div>
<div class="message"></div>



<script type="text/javascript">
	jQuery(document).ready(function() {
<?php date_default_timezone_set('America/Los_Angeles');?>
		date = new Date();

		var current_mm = '<?php echo date('M');?>';
		var current_dd = '<?php echo date('j');?>';
		var current_yy = '<?php echo date('Y');?>';
		var current_day = '<?php echo date('l');?>';
        
		var hours = '<?php echo date('H');?>';
		var minutes = '<?php echo date('i');?>';
		

		var strTime = hours+'.' +minutes;

		var currTime = hours+':'+minutes;
		
		var con = '';
		var curr_start = '';
		var curr_end = '';
		var current_time = '';
		var now = '';
		var time = '';
		
	
	if(current_day!='Saturday' && current_day!='Sunday'){
	    
	    //[Monday","Tuesday","Wednesday","Thursday","Friday"] 5 Days
	       
	    if(strTime >= 0.00 && strTime <= 15.00){ //12.00am to 3.00PM   

			con = 'con-1';

			curr_start = current_mm+' '+current_dd+', '+current_yy+' '+currTime+':00';

			curr_end = current_mm+' '+current_dd+', '+current_yy+' 15:00:00';

			current_time = new Date(curr_start).getTime();

			now = new Date(curr_end).getTime();

			distance =  now - current_time;

	    	time = distance / 1000;
	    	
	    	jQuery('#order_shipping_time').html('Ship Today');
		    	
		}
		
	}
	
	if(current_day!='Friday' && current_day!='Saturday' && current_day!='Sunday'){
	    
	    //[Monday","Tuesday","Wednesday","Thursday"] 4 Days
	    
	    	if(strTime >= 15.01 && strTime <= 23.59){
                con = 'con-2';
        		
        		curr_start = current_mm+' '+current_dd+', '+current_yy+' '+currTime+':00';
        
        		curr_end = current_mm+' '+current_dd+', '+current_yy+' 23:59:59';
        
        		current_time = new Date(curr_start).getTime();
        
        		now = new Date(curr_end).getTime();
        
        		distance =  now - current_time;
        
            	time = distance / 1000;
            	
            	jQuery('#order_shipping_time').html('will be shipped tomorrow');
        	}
	    
	}
	
	
	if(current_day!='Monday' && current_day!='Tuesday' && current_day!='Wednesday' && current_day!='Thursday'){
	    
	        //["Sunday","Friday","Saturday"] 3 Days
	        
	    	if(strTime >= 15.01 && strTime <= 23.59 && current_day=='Friday'){
                con = 'con-3';
        		
        		curr_start = current_mm+' '+current_dd+', '+current_yy+' '+currTime+':00';
                curr_end = current_mm+' '+(parseInt(current_dd)+parseInt(2))+', '+current_yy+' 23:59:59';
                
        		current_time = new Date(curr_start).getTime();
        
        		now = new Date(curr_end).getTime();
        
        		distance =  now - current_time;
        
            	time = distance / 1000;
            	
            	jQuery('#order_shipping_time').html('will be shipped on Monday');
        	}else if(current_day=='Saturday' || current_day=='Sunday'){
        	    con = 'con-4';
        		
        		curr_start = current_mm+' '+current_dd+', '+current_yy+' '+currTime+':00';
        		if(current_day=='Saturday'){
                   curr_end = current_mm+' '+(parseInt(current_dd)+parseInt(1))+', '+current_yy+' 23:59:59';
        		}else if(current_day=='Sunday'){
        		   curr_end = current_mm+' '+current_dd+', '+current_yy+' 23:59:59'; 
        		}
        		current_time = new Date(curr_start).getTime();
        
        		now = new Date(curr_end).getTime();
        
        		distance =  now - current_time;
        
            	time = distance / 1000;
            	
            	jQuery('#order_shipping_time').html('will be shipped on Monday');
        	}
	    
	}
		

		
		

    
	
    	
    	console.log('+--------------------------------------------------------------------==+');
		console.log('con: '+con);
		console.log('Start time: '+curr_start);
		console.log('End time: '+curr_end);
		console.log('Current hours and mints: '+strTime);
		console.log('WeekDay: '+current_day);
		console.log('+--------------------------------------------------------------------==+');


		var clock;
		clock = jQuery('.clock').FlipClock({
	        clockFace: 'HourlyCounter',
	        autoStart: false,
	        /*callbacks: {
	        	stop: function() {
	        		jQuery('.message').html('The clock has stopped!')
	        	}
	        }*/
	    });
			    
	    clock.setTime(time);
	    clock.setCountdown(true);
	    clock.start();

	});
</script>


<?php
return ob_get_clean();
}
add_shortcode('custom_countdown_timer_shortcode', 'custom_countdown_timer_shortcode_function');

?>