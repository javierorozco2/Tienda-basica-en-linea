<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <div id="main">

        <div id="main-header">
            <div>
               <h2 id="main-heade-title">Tienda basica en linea</h2>
                <p>&nbspBienvenido</p> 
            </div>
            <img id="gocart" src="https://www.picng.com/upload/shopping_cart/png_shopping_cart_33838.png">
        </div>

        <div id="main-body">
            <h2>Estos son los productos en tu carrito:</h2>
            <?php
                $nombre = $_GET["nombre"];
                $arch = fopen($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"r")
                or die("No se pudo abrir el archivo");
    
                $total = 0;
                while(!feof($arch)){
                    $traer = fgets($arch);
                    $linea = nl2br($traer);

                    $alinea = explode("	",$linea);

                    if(strlen($alinea[0])>1){
                        $cant = doubleval($alinea[1]);
                        $prec = doubleval($alinea[2]);

                        $total = $total + ($cant*$prec);
                        echo $linea;
                    }
                }
                echo("<h2>Su total a pagar es de : $ $total</h2>");
                fclose($arch);   
            ?>
        </div>

    </div>
    
    <script>

        document.getElementById("main-heade-title").addEventListener("click",function(){
            window.location = "welcome.php";
        })

        document.getElementById("submit").addEventListener("click",function(){
            nombre = document.getElementById("nombre").value;
            if(!(nombre==="")){
                window.location = "pedidos.php?nombre="+nombre;
            }else{
                document.getElementById("main-body-warning").removeAttribute("hidden");
            }
        });

        
    
    </script>
</body>
</html>