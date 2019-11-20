<?php

require_once "scssphp/scss.inc.php";

use Leafo\ScssPhp\Compiler;

class YDGAdmin {

    public static function compile_all() {
        self::compile_css('login');
        self::compile_css('admin');
    }

    public static function compile_css( $file_name ) {
        $scss = new Compiler();

        // settings
		$scss->setImportPaths( YDG_CHILD_THEME_DIR . '/admin/scss' ); // set path
        $scss->setFormatter('Leafo\ScssPhp\Formatter\Nested'); // set formatter

        $css = file_get_contents( YDG_CHILD_THEME_DIR . '/admin/scss/' . $file_name . '.scss' );

        try {
            $css = $scss->compile($css);
            file_put_contents( YDG_CHILD_THEME_DIR . '/admin/css/' . $file_name . '.css' , $css );
        } catch(Exception $e) {
            echo $e->getMessage();
        }

    }

    public static function admin_stylesheet() {
        wp_enqueue_style( 'ydg-admin', YDG_CHILD_THEME_URL . '/admin/css/admin.css', array(), '1.1.6' );
    }

    public static function login_stylesheet() {
        wp_enqueue_style( 'ydg-login', YDG_CHILD_THEME_URL . '/admin/css/login.css', array(), '1.0.0' );
    }

    public static function login_logo() {
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/imgs/logo.png);
                background-size: contain;
                width: auto;
            }
        </style>
        <?php
    }

}
