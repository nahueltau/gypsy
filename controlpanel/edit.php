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
        $newkeyspecs = $pantalla.','.$os.','.$memoria.','.$camara.','.$procesador.','.$compatibilidad;
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
        $sql = "UPDATE productos SET brand='$brand', model='$model', price='$price', category='$category', colorname='$colorname', colorcode='$colorcode', keyspecs='$newkeyspecs', web='$web', published=0
        WHERE id='$_GET[product]'";
        if($isDataValid){
          $conn->query($sql);
          $shoudlImgUpload = true;
        }
        /* IMAGE UPLOAD */
/*         if($shoudlImgUpload){
            require 'imageUpload.php';
        } */
    };
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM productos WHERE id='$_GET[product]'";
        $query = $conn->query($sql);
        $result = $query->fetch(PDO::FETCH_OBJ); 
        
        $keyspecs = explode(',',$result->keyspecs);
        $colornames =explode(',',$result->colorname);
        $colorcodes =explode(',',$result->colorcode);
        $numberOfColors = count($colorcodes);
    }     
?>

<?php include 'header.php'; ?>
    <script defer src="editProduct.js"></script>

    <div class="container">
    <a href="list.php">goback</a>
    <h1>Editar <?php echo $result->brand . ' ' . $result->model; ?></h1>

    <form action="<?php echo 'edit.php?product='. $result->id . '&edit=Edit' ?>" method="post" enctype="multipart/form-data">
        <h3>General</h3>
        <label for="brand" ><p>Brand   </p>
            <input type="text" id="brand" name="brand" required value="<?php echo $result->brand; ?>">
        </label>
        <label for="model" ><p>Model</p>
            <input type="text" id="model" name="model" required value="<?php echo $result->model; ?>">
        </label>
        <label for="price" ><p>Price</p>
            <input type="number" id="price" name="price" required value="<?php echo $result->price; ?>">
        </label>
        <label for="category" ><p>Category</p>
            <input type="text" id="category" name="category" value="<?php echo $result->category; ?>">
        </label>
        <h3>Colors</h3>
        <label for="colornumber" ><h5>Number of colors</h5>
            <input type="number" id="colornumber" value="<?php echo $numberOfColors; ?>" max="3" min="1" >
        </label>
        <div id="colorinputs">
        <?php for($i=1;$i<=$numberOfColors;$i++):?>
            <div>
            <label>
                <p>Color Name <?php echo $i ;?></p>
                <input name="<?php echo 'colorname' . $i ;?>" id="<?php echo 'colorname' . $i ;?>" type="text" required="" value="<?php echo $colornames[$i-1]; ?>">
            </label>
            <input name="<?php echo 'color' . $i ;?>" id="<?php echo 'color' . $i ;?>" type="color" value="<?php echo $colorcodes[$i-1]; ?>">
            </div>
        <?php endfor;?>
        </div>
        <h3>Key Specs</h3>
        <label for="pantalla" ><p>Pantalla</p>
            <input type="text" id="pantalla" name="pantalla" required value="<?php echo $keyspecs[0]; ?>">
        </label>
        <label for="os" ><p>Sistema Operativo</p>
            <input type="text" id="os" name="os" required value="<?php echo $keyspecs[1]; ?>">
        </label>
        <label for="memoria" ><p>Memoria Interna</p>
            <input type="text" id="memoria" name="memoria" required value="<?php echo $keyspecs[2]; ?>">
        </label>
        <label for="camara" ><p>Camara</p>
            <input type="text" id="camara" name="camara" required value="<?php echo $keyspecs[3]; ?>">
        </label>
        <label for="procesador" ><p>Procesador</p>
            <input type="text" id="procesador" name="procesador" required value="<?php echo $keyspecs[4]; ?>">
        </label>
        <label for="compatibilidad" ><p>Compatibilidad</p>
            <input type="text" id="compatibilidad" name="compatibilidad" required value="<?php echo $keyspecs[5]; ?>">
        </label>
        <h3>Fabricante</h3>
        <label for="fabricante" ><p>Web Fabricante</p>
            <input type="text" id="fabricante" name="fabricante" required value="<?php echo $result->web; ?>">
        </label>
        <h3>Images</h3>
        <div id=imginputs>
        <?php for($i=1;$i<=$numberOfColors;$i++):?>
            <div>
                <h5>Images for color <?php echo $i ;?></h5>
                <div>
                    <label>
                        <p>Image Front</p>
                        <input type="file" id="<?php echo 'image1color'.$i?>" name="<?php echo 'image1color'.$i?>">
                    </label><label>
                        <p>Image Back</p>
                        <input type="file" id="<?php echo 'image2color'.$i?>" name="<?php echo 'image2color'.$i?>">
                    </label>
                    <label>
                        <p>Image Side</p>
                        <input type="file" id="<?php echo 'image3color'.$i?>" name="<?php echo 'image3color'.$i?>">
                    </label>
                    <label>
                        <p>Image Extra</p>
                        <input type="file" id="<?php echo 'image4color'.$i?>" name="<?php echo 'image4color'.$i?>">
                    </label>
                </div>
            </div>
        <?php endfor;?>
        </div>

        <input type="submit" class="submit" name="submit">
    </form>
</div>
</body>
</html>