var audio   = document.getElementById( 'audio' );
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

audio.addEventListener( 'ended', function( e ) {
  last = current;
  current++;

  if ( current == len ) {
    current = 0;
  }

  changeTrack( last, current );
  audio.play();
});

playlist.addEventListener( 'click', function( e ) {
  last    = current;
  current = e.target.id;

  changeTrack( last, current );
  playstop.className = "fas fa-pause";

  audio.play();
});

playstop.addEventListener( 'click', function( e ) {
  if ( audio.paused ) {
    playstop.className = "fas fa-pause";
    audio.play();
  } else {
    playstop.className = "fas fa-play";
    audio.pause();
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
  audio.autoplay = true;

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
  audio.autoplay = true;

  changeTrack( last, current );
});

progress.addEventListener( 'click', function( e ) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;

  clickedValue = x * this.max / this.offsetWidth;

  audio.currentTime = clickedValue;
  progress.value     = clickedValue;
});

audio.addEventListener( 'timeupdate', function( e ) {
  progress.value = audio.currentTime;
});

audio.addEventListener( "loadeddata", function() {
  progress.max = audio.duration;
});

volume.addEventListener( 'click', function( e ) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;

  clickedValue = x * this.max / this.offsetWidth;

  volume.value  = clickedValue;
  audio.volume = clickedValue / 100;
});

loop.addEventListener( 'click', function( e ) {
  if ( audio.loop == true ) {
    audio.loop = false;
    loop.style  = "color: white";
  } else {
    audio.loop = true;
    loop.style  = "color: #f4511e";
  }
});

function changeTrack( last_songId, current_songId ) {
  tracks[ last_songId ].classList.remove( "active" );
  tracks[ current_songId ].classList.add( "active" );
  audio.src = "inc/loadSong.php?songId=" + current;
  audio.load();

  document.title = "MLib [" + tracks[ current_songId ].text + "]";
}
