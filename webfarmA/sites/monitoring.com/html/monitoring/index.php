<?php
  $ini = parse_ini_file('/var/www/html/monitoring.com/html/config/app.ini', true);
  $app_configuration = $ini['MAIN'];
?>
<html>
 <head>
  <title>Monitoring (<?php echo $app_configuration['environmentName'] ?>)</title>
 </head>
 <body>
   <h1>Monitoring (<?php echo $app_configuration['environmentName'] ?>)</h1>

   <font>Contents of this site:</font>
   <a href="mon_page1.html">Test page1</a>
   <a href="mon_page2.html">Test page2</a>
 </body>
</html>
