<?php

    $st;

    function obtenerAlmacen(){

        global $st;
        //Borrar estas variables
        $producto = $_GET["producto"];
        $cantidad = intval($_GET["cantidad"]);
        //----------------------

        $almacenData = array();
        
        //Obtención de productos ya existentes en el inventario
        $arch = fopen("almacen.txt","r")
        or die("No se pudo abrir almacen.txt");
    
        $i = 0;
        while(!feof($arch)){
            $traer = fgets($arch);
            $linea = nl2br($traer);

            //Se convierte la linea en array para ubicar la cantidad y restar
            $arrTemp = explode("	",$linea);
            $arrTemp[2] = doubleval($arrTemp[2]);
            
            if($arrTemp[0] === $producto){
                if($arrTemp[1]>0){
                    $arrTemp[1] = $arrTemp[1] - $cantidad;
                    $st=1;
                }else{
                    $arrTemp[1] = 0;
                    $st=0;
                }

            }

            //Se regresa a la linea a el tipo de dato original (string)
            $linea = trim(implode("	",$arrTemp));


            //Se agrega a la variable de escritura
            $almacenData[$i] = trim($linea);
            $i = $i + 1;
        }
        fclose($arch);
        
        return $almacenData;

    }
    
    function nuevoAlmacen($a){

        //Borrar actuales del almacen
        $arch = fopen("almacen.txt","w")
        or die("No se pudo abrir almacen.txt");
        fwrite($arch,"");
        fclose($arch);

        //Crear nuevos datos del almacen
        $info = "";
        for ($i=0; $i < sizeof($a) ; $i++) { 
            if($i< (sizeof($a)-1)){
                $info .= $a[$i] . "\n";
            }else{
                $info .= $a[$i];
            }
        }

        file_put_contents("almacen.txt",$info);

    }

    function agregarACart($a){
        global $st;

        $nombre = $_GET["nombre"];
        $producto = $_GET["producto"];
        $cantidad = $_GET["cantidad"];   
        $precio = "";   
        
        //Obtener el precio del producto
        for ($i=0; $i < sizeof($a); $i++) { 
            $aArr = explode("	",$a[$i]);
            if($aArr[0]===$producto){
                $precio = $aArr[2];
            }
        }

        //Comprobar si el producto existe
        $existe = 0;
        if($st === 1){
            $arch = fopen($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"r")
            or die("No se pudo abrir el archivo");
            
            while(!feof($arch)){
                $traer = fgets($arch);
                $linea = nl2br($traer);
                $lineaArr = explode("	",$linea);
                if($lineaArr[0]===$producto){
                    $existe = 1;
                }
            }
            fclose($arch);
        }

        //Si el producto no existe, crear uno nuevo
        if($existe===0 && $st===1){
            $arch2 = fopen($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"a+")
            or die("No se pudo abrir el archivo");
            
            $txt = $producto."	".$cantidad."	".$precio."\n";
                
            fwrite($arch2,$txt);
            fclose($arch2);
        }

        //Si el producto ya existe, suma la cantidad
        if($existe===1 && $st===1){
            $arch = fopen($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"a+")
            or die("No se pudo abrir el archivo");
            
            //Guardar temporalmente el archivo
            $gTemp = array();
            $c=0;

            while(!feof($arch)){
                $traer = fgets($arch);
                $linea = nl2br($traer);
                
                $gTemp[$c] = trim($linea);
                $c = $c+1;
            }
            fclose($arch);

            //Escribir de nuevo en el archivo con nuevos datos    
            $arch = fopen($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"w+")
            or die("No se pudo abrir el archivo");  
            for ($i=0; $i < sizeof($gTemp); $i++) { 
                
                $strtmp = explode("	",$gTemp[$i]);
                $strtmp[2] = doubleval($strtmp[2]);

                if($strtmp[0] === $producto){
                    $strtmp[1] = $strtmp[1] + $cantidad;
                }

                $txttmp = implode("	",$strtmp);

                fwrite($arch,trim($strtmp[0])."	".trim($strtmp[1])."	".trim($strtmp[2])."\n");
            }
            fclose($arch);
            
        }
    }

    $almacen = obtenerAlmacen();
    nuevoAlmacen($almacen);
    agregarACart($almacen);
?>
    <script>
        window.location = "pedidos.php?nombre=<?=$_GET['nombre']?>"+"&st=<?=$st?>";
    </script>