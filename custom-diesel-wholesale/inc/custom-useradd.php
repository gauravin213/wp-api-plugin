<?php
/*
* Start:Add New user
*/
//custom_diese
add_action( 'add_meta_boxes', 'custom_diese_add_meta_boxes_fun');
function custom_diese_add_meta_boxes_fun(){

   add_meta_box( 'custom_diese_create_user', 'Create User', 'custom_diese_create_user', 'shop_order', 'side', 'high' );
}


function custom_diese_create_user(){
    global $wp_roles;
    $roles = $wp_roles->get_names();
    
    //echo get_option('admin_email');

  ?>
  
<style>
#custom_diese_user_msg {
    border: 1px solid;
    padding: 5px;
    color: #fff;
    margin-top: 11px;
}
</style>
   <div class="add-user-comyainer">
    
    <a href="#TB_inline?width=600&height=550&inlineId=modal-window-id" class="button button-primary thickbox">Add New User</a>
    
    <div id="modal-window-id" style="display:none;">
            
        <div class="control-box ds_model">
            <fieldset>
            <legend>Add New User</legend>
            
            <table class="form-table">
            <tbody>
                
                <!--<tr>
                    <th scope="row">
                    <label for="Firstname">Firstname</label>
                    </th>
                    <td>
                        <input type="text" name="custom_fname" id="custom_fname" value="Test" placeholder="Firstname">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                    <label for="Lastname">Lastname</label>
                    </th>
                    <td>
                         <input type="text" name="custom_lname" id="custom_lname" value="Tester" placeholder="Lastname">
                    </td>
                </tr>-->
                
                <tr>
                    <th scope="row">
                    <label for="UserName">UserName</label>
                    </th>
                    <td>
                         <input type="text" name="custom_username" id="custom_username" value="" placeholder="UserName">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                    <label for="Email">Email</label>
                    </th>
                    <td>
                         <input type="text" name="custom_email" id="custom_email"  value="" placeholder="Email">
                    </td>
                </tr>
                
                
                <tr>
                    <th scope="row">
                    <label for="role">Role</label>
                    </th>
                    <td class="radio_backend">
                        <p><input type="radio" name="custom_role" value="customer">Customer</p>
                        <p><input type="radio" name="custom_role" value="wholesale_customer">Wholesale Customer</p>
                    </td>
                </tr>
            
            
            </tbody>
            </table>
            </fieldset>
        </div>
    
        <div class="insert-box">
            
            <div class="submitbox">
            <input type="button" id="custom_diese_ajax_action_add_user" class="button button-primary insert-tag" value="Submit" />
            </div>
            
            
            <div id="custom_diese_user_loader" style="display:none">
                Loading
            </div>
            <div id="custom_diese_user_msg" style="display:none">
                User created successfylly.
            </div>
        </div>
    
          
    </div>
</div>
  <?php
}



add_action( 'wp_ajax_custom_diese_ajax_action_add_user', 'ajax_function_custom_diese_ajax_action_add_user');
add_action( 'wp_ajax_nopriv_custom_diese_ajax_action_add_user', 'ajax_function_custom_diese_ajax_action_add_user');
function ajax_function_custom_diese_ajax_action_add_user(){
    
    
    $post_id = $_POST['post_id'];
    $user_name = $_POST['custom_username'];
    $user_email = $_POST['custom_email'];
    $custom_role = $_POST['custom_role'];
    $args = array();
    
    $user_id = username_exists( $user_name );
    $email_id = email_exists($user_email);
    
    if ( !$user_id ) {
        
        if ($email_id == false) {
            
            $random_password = wp_generate_password( 12, false );
            //$user_id = wp_create_user( $user_name, $random_password, $user_email );
            
             
            $user_id = wc_create_new_customer( $user_email, $user_name, $random_password, $args );
           
            if (!empty($custom_role)) {
                 wp_update_user( array ('ID' => $user_id, 'role' => $custom_role) );
            }
    
            echo 1;
            /**/
            /*$name = $user_name;
            $email = $user_email;
            $message = 'This is your  username: '.$user_name.' and password: '.$random_password;
            $to = 'gaurav.clagtech@gmail.com'; //get_option('admin_email');
            $subject = "Test tab";
            $headers = 'From: '. $email . "\r\n" .'Reply-To: ' . $email . "\r\n";
            
            $sent = wp_mail($to, $subject, strip_tags($message), $headers);
            $sent = wp_mail($email, $subject, strip_tags($message), $headers);
            if($sent) {
                 echo 1;
            }
            else  {
                echo 2;
            }*/
            /**/
        
        }else{
            
            echo 3;
            
        }
        
    }else {
        echo 4;
    }


    die();
}

?>