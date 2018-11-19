<?php
  $ini = parse_ini_file('config/app.ini', true);
  $app_configuration = $ini['MAIN'];

  $version_ini = parse_ini_file('config/version.ini', true);
  $version_configuration = $version_ini['MAIN'];
?>
<html>
 <head>
  <title>Version (<?php echo $app_configuration['environmentName'] ?>)</title>
 </head>
 <body>
   <h1>Version</h1>
   <h3>Web Application Name: <?php echo $version_configuration['webapp'] ?></h3>
   <h3>Environment: <?php echo $app_configuration['environmentName'] ?></h3>
   <h3>Git branch/version: <?php echo $version_configuration['version'] ?></h3>
 </body>
</html>
