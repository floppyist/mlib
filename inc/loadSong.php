<?php

include_once( "../libs/mlib.class.php" );
include_once( "../cfg/config.php" );

session_start();

if ( isset( $_SESSION[ "login" ] ) && $_SESSION[ "login" ] == true ) {
  $mlib = new Mlib( $musicPath );
  $mlib->loadPlaylist( $_SESSION[ "user" ] );

  $mlib->getSelectedSong( $_GET[ "songId" ] );
}

?>
