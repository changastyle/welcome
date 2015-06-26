<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to Nicolas Grossi billboard</title>
        <link rel="stylesheet" href="frontend/css/general.css">
        <link rel="stylesheet" href="frontend/css/index.css">
        <link rel="stylesheet" href="frontend/css/grillas.css">
        <!--<link rel="stylesheet" href="frontend/css/general.css">-->
        <?php
         echo $GLOBALS;
         
        ?>
    </head>
    <body>
        <div class="paneles" id="banner"></div>
        <div class="paneles" id="body">
               <div class="paneles" id="panelPrincipal">
                         <?PHP 
                         
                         require './backend/conexionDB.php';
                         require './frontend/grilla.php';
                         
                         conectar();

                         $arr = query("SELECT * FROM usuarios");
                        
                         tabla("tablita",$arr);
                         
                         ?>

                         <footer class="paneles" id="footer">FOOTERRRR</footer>
               </div>
            <div class="paneles panelesLaterales" id="panelIZQ"></div>
            <div class="paneles panelesLaterales" id="panelDER"></div>
            
            
        </div>

           
    </body>
</html>
