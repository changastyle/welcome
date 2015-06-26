<?PHP
//ESTOS DATOS DESPUES LOS TENGO QUE LEER DE UN ARCHIVO DE CONF:
$user = 'root';
$passwd = 'descargar';
$schema = 'pruebas';
$port = 3306;
$host = 'localhost';
$motor = 'mysql';
$conexion = null;
     
function conectar()
{
     global $user, $passwd, $schema, $port, $host, $motor, $conexion;
     
     if($motor == 'mysql')
     {       
        $conexion=new mysqli($host,$user,$passwd,$schema); 

         if ($conexion->connect_error) 
           {  
                echo "USUARIO = ". $user ."<br>";
                echo "PASSWORD = ". $passwd ."<br>";
                echo "SCHEMA = ".$schema. "<br>";
                echo "PORT = " . $port ."<br>";
                echo "HOST= " . $host . "<br>";
                echo "MOTOR = " . $motor . "<br>";
                
                echo 'Error de Conexión (' . $conexion->connect_errno . ') '. $conexion->connect_error;
                echo $conexion->error;

           }
           else
           {
                   //echo "SE conecto la bosta esta";
           }     
       }
     else if($motor == 'postgres')
     {
          $conexion = pg_connect(" host=" . $host ." port=" . $port ." dbname=" . $schema ." ".$credenciales)or die("Error: De Conexion con PostgresSQL ");
     }
}
function desconectar($conexion)
{
        global $conexion, $motor;
        
        if($motor == 'mysql')
        {
             $conexion->close();
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
                
     $result = array();
     
     if($motor == 'mysql')
     {
        $result = $conexion->query($sql);
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
                        array_push($result,$arrayFila);
                }
     }
     else
     {
             echo "FALLO MOTOR : " . $motor;
     }
     
     return $result;
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
