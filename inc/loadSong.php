<?php

include_once( "../libs/mlib.class.php" );

session_start();

if ( isset( $_SESSION[ "login" ] ) && $_SESSION[ "login" ] == true ) {
  $config = json_decode( file_get_contents( "../cfg/config.json" ), true );

  $mlib = new Mlib( $config[ "general" ][ "data_path" ] );
  $mlib->loadPlaylist( $_SESSION[ "user" ] );
  $mlib->getSelectedSong( $_GET[ "songId" ] );
}

?>
