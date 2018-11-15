<?php
  $ini = parse_ini_file('config/app.ini', true);
  $app_configuration = $ini['MAIN'];
?>
<html>
 <head>
  <title>HelloWorld (<?php echo $app_configuration['environmentName'] ?>)</title>
 </head>
 <body>
   <h1>HelloWorld (<?php echo $app_configuration['environmentName'] ?>)</h1>

   <font>Contents of this site:</font>
   <a href="test_page1.html">Test page1</a>
   <a href="test_page2.html">Test page2</a>
 </body>
</html>
