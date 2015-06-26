<?php

     function tabla($idGrilla,$arr)
      {
             echo "<table class='tablas' id='" . $idGrilla . "' >";
             
             foreach ($arr as $a)
             {
                     echo "<tr class='rows rows".$idGrilla."' >";
                     foreach ($a as $b)
                      {
                             echo "<td class='tablesdatas' >";
                             echo $b;
                             echo "</td>";
                      }
                      echo "</tr>";
             }
             echo "</table>";
      }
     
?>
