<?PHP
//ESTOS DATOS DESPUES LOS TENGO QUE LEER DE UN ARCHIVO DE CONF:
$user = 'root';
$passwd = 'descargar';
$schema = 'pruebas';
$port = 3306;
$credenciales = "user=postgres password=";
$host = 'localhost';
$motor = 'mysql';

//ESTABLESCO 1 CONEXION:
function conectar()
{
     global $user, $passwd, $db, $port, $credenciales, $host, $motor;
     
     $conexion = null;
     
     if($motor == 'mysql')
     {
          /*$conexion = mysql_connect($host, $user, $passwd) or die(mysql_error());*/          //CONEXION VIEJA P.ESTRUCTURADO.
          $conexion = mysqli_connect($host, $user, $passwd, $schema);
          if (mysqli_connect_errno($mysqli)) 
          {
              echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
          }
          else
          {
             echo "C" .$conexion;
          }
     }
     else if($motor == 'postgres')
     {
          $conexion = pg_connect(" host=" . $host ." port=" . $port ." dbname=" . $schema ." ".$credenciales)or die("Error: De Conexion con PostgresSQL ");
     }

     if(!$conexion)
     {
              echo "conexion fallida";
     }
     else
     {
              echo "success connection to ".$motor. ' @ ' .$host .":".$port.".";
     }
     return conexion;
}
function desconectar($conexion)
{
     if($motor == 'mysql')
     {
          mysql_close($conexion);
     }
     else if($motor == 'postgres')
     {
          pg_close($conexion);
     }
     
     if($conexion == null)
     {
          echo "Cerre la conexion.";
     }
}

function query($sql)
{
     global $conexion, $motor;
     
     $respuestas = array();
     
     if($conexion == null)
     {
          $conexion = conectar();
     }
     else
     {
          echo "Habia conexion";
     }
             
     if($motor == 'mysql')
     {
          echo "<br>MYSQL" .  $sql .  $conexion->query($sql);
     }
     else if($motor == 'postgres')
     {
          $statement = pg_query($conexion,$sql)or die("ERROR al realizar SQL " .  $sql );

          //DEVUELVE CANTIDAD DE FILAS DE LA CONSULTA:

          while($fila = pg_fetch_row($statement))
          {
               $arrayFila = array();
               for($i = 0 ; $i < sizeof($fila); $i++ )
               {
                      array_push($arrayFila, $fila[$i]);
               }
               array_push($respuestas,$arrayFila);
          }
     }     
     else
     {
          echo "MOTOR = " . $motor;
     }
     return $respuestas;
}
function insert($sql)
{
	global $conexion;
	  
	$result = pg_query($sql); 
	
	return $result;
}
function insertMultiple($arrSQL)
{
	pg_query("BEGIN") or die("Could not start transaction\n");
	$res = true;
	
	foreach ($arrSQL as $sql)
	{
		$resAux = pg_query($sql)or die(pg_last_error());
		$res = $res and $resAux;
	}
	
	if($res)
	{
		pg_query("COMMIT") or die("Transaction commit failed\n");
	}
	else 
	{
   	 	echo "Rolling back transaction\n";
    	pg_query("ROLLBACK") or die("Transaction rollback failed\n");
	}
}

?>
