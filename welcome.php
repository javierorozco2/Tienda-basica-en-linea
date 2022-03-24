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
            <h2>Porfavor, ingresa tu nombre:</h2>
            <p style="color: #FF0000;" id="main-body-warning" hidden>*Ingresa tu nombre*</p>
            <input type="text" id="nombre" name="nombre">
            <button type="submit" id="submit">Enviar</button>
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