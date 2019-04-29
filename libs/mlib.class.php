<?php

class Mlib {
  private $musicPath;
  private $music = array();

  function  __construct( $musicPath ) {
    $this->musicPath = $musicPath;
  }

  public function loadPlaylist( $username ) {
    $songs = glob( $this->musicPath . "/" . $username . "/*.mp3" );

    $playlist = "";

    for ( $i = 0; $i < sizeof( $songs ); $i++ ) {
      $path = $songs[ $i ];
      list( $title, $interpret ) = explode( "-", pathinfo( $songs[ $i ], PATHINFO_FILENAME ) );

      $this->music[ $i ] = $path;

      $playlist .= "<li><a id='$i'>$title - $interpret</a></li>";
    }

    return $playlist;
  }

  /**
   * Returns the content of the given songId which came usally from the js-player.
   */
  public function getSelectedSong( $songId ) {
    if ( isset( $this->music[ $songId ] ) ) {
      header( "Content-Type: " . mime_content_type( $this->music[ $songId ] ) );
      readfile( $this->music[ $songId ] );
    }
  }
}

?>
