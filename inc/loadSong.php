<?php

include_once( "../libs/muslib.class.php" );
include_once( "../cfg/config.php" );

session_start();

if ( isset( $_SESSION[ "login" ] ) && $_SESSION[ "login" ] == true ) {
  $muslib = new Muslib( $musicPath );
  $muslib->loadPlaylist( $_SESSION[ "user" ] );

  echo $muslib->getSelectedSong( $_GET[ "songId" ] );
}

?>
