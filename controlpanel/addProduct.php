<?php 
    require 'connection.php';
    if(isset($_POST['submit'])){

        /* COLOR NAME */
        $regExp = "/^[a-zA-Z]+$/";
        $colorname = '';
        
            if(isset($_POST['colorname1'])){
                if(preg_match($regExp,$_POST['colorname1'])){
                $trim = str_replace(' ','',$_POST['colorname1']);
                $colorname = $trim;
            };
        }
        
        if(isset($_POST['colorname2'])){
            if(preg_match($regExp,$_POST['colorname2'])){
            $trim = str_replace(' ','',$_POST['colorname2']);
            $colorname = $colorname.','.$trim;
        };
        }
        
        if(isset($_POST['colorname3'])){
            if(preg_match($regExp,$_POST['colorname3'])){
            $trim = str_replace(' ','',$_POST['colorname3']);
            $colorname = $colorname.','.$trim;
        };
        }

        /* COLOR CODE */
        $colorcode = $_POST['color1'];
        if(isset($_POST['color2'])){$colorcode = $colorcode.','.$_POST['color2'];};
        if(isset($_POST['color3'])){$colorcode = $colorcode.','.$_POST['color3'];};
        /* KEY SPECS */
        $pantalla = str_replace(' ','',$_POST['pantalla']);
        $os = str_replace(' ','',$_POST['os']);
        $memoria = str_replace(' ','',$_POST['memoria']);
        $camara = str_replace(' ','',$_POST['camara']);
        $procesador = str_replace(' ','',$_POST['procesador']);
        $compatibilidad = str_replace(' ','',$_POST['compatibilidad']);
        $keyspecs = $pantalla.','.$os.','.$memoria.','.$camara.','.$procesador.','.$compatibilidad;
        /* BRAND, MODEL, PRICE, CATEGORY & WEB */
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $web = $_POST['fabricante'];
        /* VALIDATION */
        $isDataValid = true;
        $shoudlImgUpload = false;

        /* SQL */
        $sql = "INSERT INTO productos(brand,model,price,category,colorname,colorcode,keyspecs,web)
        VALUES ('$brand','$model','$price','$category','$colorname','$colorcode','$keyspecs','$web')";
        if($isDataValid){
          $conn->query($sql);
          $shoudlImgUpload = true;
        }
        /* IMAGE UPLOAD */
        if($shoudlImgUpload){
            require 'imageUpload.php';
        }
    };      
?>

<?php include 'header.php'; ?>
    <script defer src="addProduct.js"></script>

    <div class="container">
    <h1>Add Products</h1>

    <form action="addProduct.php" method="post" enctype="multipart/form-data">
        <h3>General</h3>
        <label for="brand" ><p>Brand   </p>
            <input type="text" id="brand" name="brand" required>
        </label>
        <label for="model" ><p>Model</p>
            <input type="text" id="model" name="model" required>
        </label>
        <label for="price" ><p>Price</p>
            <input type="number" id="price" name="price" required>
        </label>
        <label for="category" ><p>Category</p>
            <input type="text" id="category" name="category">
        </label>
        <h3>Colors</h3>
        <label for="colornumber" ><h5>Number of colors</h5>
            <input type="number" id="colornumber" max="3" min="1" value="1">
        </label>
        <div id="colorinputs">
           
        </div>

        <h3>Key Specs</h3>
        <label for="pantalla" ><p>Pantalla</p>
            <input type="text" id="pantalla" name="pantalla" required>
        </label>
        <label for="os" ><p>Sistema Operativo</p>
            <input type="text" id="os" name="os" required>
        </label>
        <label for="memoria" ><p>Memoria Interna</p>
            <input type="text" id="memoria" name="memoria" required>
        </label>
        <label for="camara" ><p>Camara</p>
            <input type="text" id="camara" name="camara" required>
        </label>
        <label for="procesador" ><p>Procesador</p>
            <input type="text" id="procesador" name="procesador" required>
        </label>
        <label for="compatibilidad" ><p>Compatibilidad</p>
            <input type="text" id="compatibilidad" name="compatibilidad" required>
        </label>
        <h3>Fabricante</h3>
        <label for="fabricante" ><p>Web Fabricante</p>
            <input type="text" id="fabricante" name="fabricante" required>
        </label>
        <h3>Images</h3>
        <div id=imginputs>

        </div>

        <input type="submit" class="submit" name="submit">
    </form>
</div>
</body>
</html>