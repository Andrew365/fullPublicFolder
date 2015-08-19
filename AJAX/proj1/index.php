<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript">
    function ajax(){
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function(){
        if(xhr.readyState === 4){
          console.log(xhr.responseText);
        }
      };
      xhr.open('GET', 'loadMe.php');
      xhr.send();
    }
    </script>
  </head>
  <body>
    <div id="header">
    Hello
    </div>
    <button type="button" name="button" onclick="ajax();"></button>
  </body>
</html>