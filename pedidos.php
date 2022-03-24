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

        <?php 
            //Recuperación del nombre
            parse_str($_SERVER["REQUEST_URI"], $array); 
            $nombre = $array["/actividad3/pedidos_php?nombre"];
            //Creación de directorio unico
            $nmcorto = str_replace(" ","", $nombre);

            if (!is_dir($nmcorto)) {
                mkdir($nmcorto);
            }

            if(!file_exists($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"))){
                file_put_contents($nombre."/".date("d") . "-" . date("m") . "-" . date("Y"),"");
            }
        ?>
        <div id="main-body">
            <h2>Hola <?=$nombre?>, selecciona un producto del catalogo.</h2>
            
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

            <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad">

            <p style="color:#FF0000;" id="warning" hidden></p>

            <button type="submit" id="enviar">Enviar</button>
        
        </div>

    </div>
    
    <script type="text/javascript">

        //Redireccionar a carrito
        document.getElementById("gocart").addEventListener("click",function(){
            window.location = "viewCart.php?nombre=<?=$nombre?>";
        })

        // Redireccionar al dar clic al h1
        document.getElementById("main-heade-title").addEventListener("click",function(){
            window.location = "welcome.php";
        });

        // Agregar producto al carrito
        document.getElementById("enviar").addEventListener("click",function(){
            cantidad = document.getElementById("cantidad").value;
            if(!(cantidad==="")){
                producto = document.getElementById("catalogo").value.split("	")[0];
                window.location =    "addCart.php?nombre=<?=$nombre?>&producto="+producto+"&cantidad="+cantidad;

            }else{
                imprimirMsj("Ingresa una cantidad","#FF0000");
            }

        });

        // Mostrar mensaje si se agrego correctamente al carrito
        function success(){
            st = obtenervarURL("st");
            if(st === "1"){
                imprimirMsj("Producto agregado correctamente", "#00FF00");
            }else if(st === "0"){
                imprimirMsj("Producto sin stock", "#000000")
            }
        }

        // Funcion similar al $_GET de php
        function obtenervarURL(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }


        // Imprimir mensaje que muestre el estado de algun proceso
        function imprimirMsj(texto, color){
            errorCant = document.getElementById("warning"); 
            errorCant.removeAttribute("hidden");
            errorCant.innerHTML = texto;
            errorCant.style.color = color;
        }

        window.onload = function(){
            success();
        }

    </script>
</body>
</html>