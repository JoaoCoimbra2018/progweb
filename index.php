<?php
$opcao = "cliListar.php";
if (isset($_GET["opcao"])) {
    $opcao = $_GET["opcao"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Prog Web</title>
    <meta charset="UTF-8">
<style>
#menu {width: 14%; 
       height: 99vh; 
       background: rgb(210,110,90); 
       margin: 0;
       float: left;}
#pagina {width: 86%; 
         height 99vh; 
         background: rgb(255,220,210);
         float: left;}         
</style>
<head>
<body>
<div id="menu">
    <iframe src="menu.htm" width="100%" height="100%" style="min-height: 98vh;" frameborder="0">
    </iframe>
</div>
<div id="pagina">
    <?php
    echo "<iframe src='".$opcao."' width='100%' height='100%' style='min-height: 98vh;' frameborder='0'></iframe>";
    ?>
</div>  
</body>
</html>