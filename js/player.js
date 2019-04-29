var player   = document.getElementById( 'audio' );
var playlist = document.getElementById( 'playlist' );
var playstop = document.getElementById( 'playstop' );
var forward  = document.getElementById( 'forward' );
var backward = document.getElementById( 'backward' );
var progress = document.getElementById( 'progress' );
var volume   = document.getElementById( 'volbar' );
var loop     = document.getElementById( 'loop' );

// setup default values
var current  = 0;
var tracks   = playlist.getElementsByTagName( 'a' );
var len      = tracks.length;

// set first song to default
changeTrack( current, current );

player.addEventListener( 'ended', function( e ) {
  last = current;
  current++;

  if ( current == len ) {
    current = 0;
  }

  changeTrack( last, current );
  player.play();
});

playlist.addEventListener( 'click', function( e ) {
  last    = current;
  current = e.target.id;

  changeTrack( last, current );
  playstop.className = "fas fa-pause";

  player.play();
});

playstop.addEventListener( 'click', function( e ) {
  if ( player.paused ) {
    playstop.className = "fas fa-pause";
    player.play();
  } else {
    playstop.className = "fas fa-play";
    player.pause();
  }
});

forward.addEventListener( 'click', function( e ) {
  last = current;

  if ( current == len - 1) {
    current = 0;
  } else {
    current++;
  }

  playstop.className = "fas fa-pause";
  player.autoplay = true;

  changeTrack( last, current );
});

backward.addEventListener( 'click', function( e ) {
  last = current;

  if ( current == 0 ) {
    current = len - 1;
  } else {
    current--;
  }

  playstop.className = "fas fa-pause";
  player.autoplay = true;

  changeTrack( last, current );
});

progress.addEventListener( 'click', function( e ) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;

  clickedValue = x * this.max / this.offsetWidth;

  player.currentTime = clickedValue;
  progress.value     = clickedValue;
});

player.addEventListener( 'timeupdate', function( e ) {
  progress.value = player.currentTime;
});

player.addEventListener( "loadeddata", function() {
  progress.max = player.duration;
});

volume.addEventListener( 'click', function( e ) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;

  clickedValue = x * this.max / this.offsetWidth;

  volume.value  = clickedValue;
  player.volume = clickedValue / 100;
});

loop.addEventListener( 'click', function( e ) {
  if ( player.loop == true ) {
    player.loop = false;
    loop.style  = "color: white";
  } else {
    player.loop = true;
    loop.style  = "color: #f4511e";
  }
});

function changeTrack( last_songId, current_songId ) {
  tracks[ last_songId ].classList.remove( "active" );
  tracks[ current_songId ].classList.add( "active" );
  player.src = "inc/loadSong.php?songId=" + current;
  player.load();

  document.title = "MLib [" + tracks[ current_songId ].text + "]";
}
