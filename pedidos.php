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
            <img src="https://www.picng.com/upload/shopping_cart/png_shopping_cart_33838.png">
        </div>

        <?php 
            //Recuperación del nombre
            parse_str($_SERVER["REQUEST_URI"], $array); 
            $nombre = $array["/pedidos_php?nombre"];
            //Creación de directorio unico
            $path = str_replace($nombre,""," ");

            if (!is_dir($path)) {
                mkdir($path);
            }
        ?>
        <div id="main-body">
            <h2>Hola <?=$nombre?>, selecciona un producto del catalogo.</h2>
            
            <input type="number" name="cantidad">
            
            <select name="catalogo" id="catalogo">
                <?php
                    //ABRIR ARCHIVO ALMACEN.TXT PARA SU LECTURA Y IMPRIMIR EN <option>
                    $arch = fopen("almacen.txt","r")
                    or die("No se pudo abrir almacen.txt");

                    while(!feof($arch)){
                        $traer = fgets($arch);
                        $linea = nl2br($traer);
                        echo " <option value='$linea'>$linea</option>";
                    }
                    fclose($arch);
                ?>
            </select>
            <button type="submit">Enviar</button>
        
        </div>

    </div>
    
    <script>

        document.getElementById("main-heade-title").addEventListener("click",function(){
            window.location = "welcome.php";
        })

    </script>
</body>
</html>