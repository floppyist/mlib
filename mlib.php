<?php

include_once( "libs/temple.class.php" );
include_once( "libs/muslib.class.php" );

$temple = new Temple( "html/templates", "html/components", false );

session_start();

if ( isset( $_POST[ "logout" ] ) ) {
  session_destroy();

  $parameters[ "info.login" ] = "sucessfully logged out";
  $temple->renderTemplate( "login", $parameters );

  exit();
}

# check if form was submitted and validate credentials, otherwise show login again
if ( isset( $_POST[ "auth" ] ) ) {
  if ( $_POST[ "user" ] == "root" && $_POST[ "pass" ] == "root" || $_POST[ "user" ] == "floppyist" && $_POST[ "pass" ] == "awesomepw" ) {
    $_SESSION[ "login" ] = true;
    $_SESSION[ "user" ]  = $_POST[ "user" ];
  } else {
    # print info if credentials are invalid
    $parameters[ "info.login" ] = "invalid credentials";

    $temple->renderTemplate( "login", $parameters );

    exit();
  }
}

if ( isset( $_SESSION[ "login" ] ) ) {
  if ( $_SESSION[ "login" ] == true ) {
    $muslib = new Muslib( "/srv/data/music" );

    # add content to the available attributes from the components
    $parameters[ "css" ]       = "<link rel='stylesheet' href='css/dashboard/dashboard.css'/>";
    $parameters[ "greetings" ] = $_SESSION[ "user" ];
    $parameters[ "songs" ]     = $muslib->loadPlaylist( $_SESSION[ "user" ] );

    $temple->renderTemplate( "dashboard", $parameters );

    exit();
  }
}

# last option is to show login form if nothing belongs to the user request
$temple->renderTemplate( "login", "" );

?>
