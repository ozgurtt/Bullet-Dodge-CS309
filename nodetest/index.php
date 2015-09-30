<?php 
session_start();
$username = $_SESSION['uname'];
?>
<!doctype html>
<html>
  <head>
    <title>Socket.IO chat</title>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
      #users ul { text-align: center; }
      #users li { list-style-type: none; text-align: center; }
    </style>
  </head>
  <body>
  <div style="width:80%; float: left;">
    <ul id="messages"></ul>
    <form action="">
      <input id="m" autocomplete="off" /><button>Send</button>
    </form>
    </div>
    <div style="width:20%; float: left;">
    <p style="text-align:center;"><b>ONLINE USERS</b></p>
    <ul id="users">
    </ul>
    </div>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
      <script>
      var socket = io.connect('http://proj-309-18.cs.iastate.edu:8080');

      $('form').submit(function(){
        socket.emit('chat message', $('#m').val());
        $('#m').val('');
        return false;
      });

      socket.on('chat message', function(msg){
        $('#messages').append($('<li>').text(msg));
      });

      socket.on('connect', function(){
        socket.emit('register', <?php echo "'".$username."'"; ?>);
      });

      socket.on('disconnect', function(){
        console.log("disconnected");
      });

      socket.on('list online users', function(data){
        $("#users").empty();
        for(user in data){
          $("#users").append($('<li>').text(user));
        }
      });
      
</script>
  </body>
</html>