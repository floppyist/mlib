<!DOCTYPE html>
<html>
  <head>
    {{header}}
  </head>
  <body>
      <div class='navbar-up'>
        {{navbar}}
      </div>
      <div class='navbar-down'>
        {{userinfo}}
        {{logout}}
        <button id='playlists'>Playlists</button>
        <button id='download'>Download</button>
      </div>
    <div class='content'>
      <ul id='playlist'>
        {{playlist}}
      </ul>
    </div>
    <div class='footer'>
      {{player}}
    </div>
  </body>
</html>
