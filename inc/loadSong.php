<?php
include_once( "../libs/muslib.class.php" );

session_start();

if ( isset( $_SESSION[ "login" ] ) && $_SESSION[ "login" ] == true ) {
  $muslib = new Muslib( "/srv/data/music" );
  $muslib->loadPlaylist( $_SESSION[ "user" ] );

  echo $muslib->getSelectedSong( $_GET[ "songId" ] );
}
?>
