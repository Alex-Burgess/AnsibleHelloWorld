<?php
  $ini = parse_ini_file('/var/www/html/tools.com/html/config/app.ini', true);
  $app_configuration = $ini['MAIN'];
?>
<html>
 <head>
  <title>Tools (<?php echo $app_configuration['environmentName'] ?>)</title>
 </head>
 <body>
   <h1>Tools (<?php echo $app_configuration['environmentName'] ?>)</h1>

   <font>Contents of this site:</font>
   <a href="tools_page1.html">Tools page1</a>
   <a href="tools_page2.html">Tools page2</a>
 </body>
</html>
