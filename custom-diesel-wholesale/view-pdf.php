<?php
if(isset($_GET['pdfn'])){
    
    $file_name = $_GET['pdfn'];
    
    //$full_path = 'https://www.dieseltruckpartsdirect.com/sandbox2/wp-content/uploads/net30-pdf/'.$file_name;
    
    $full_path = $file_name;
    
    $type  =  'inline'; //inline, attachment
    
    header( 'Content-type: application/pdf' );
    header( 'Content-Disposition: ' . $type . '; filename="' . basename( $full_path ) . '"' );
    header( 'Content-Transfer-Encoding: binary' );
    header( 'Content-Length: ' . filesize( $full_path ) );
    header( 'Accept-Ranges: bytes' );
    
    readfile( $full_path );
    exit;

}
?>