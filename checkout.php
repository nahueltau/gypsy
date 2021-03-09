<?php
    $redirect= '';
    $shouldRedirect=false;
    if(isset($_GET['model'])){
        require "controlpanel/connection.php";
        /* Recover model format to query database */
        $currentModel = str_replace('-','.',str_replace('_',' ',$_GET['model'])); 
        $stmt = $conn->prepare("SELECT * FROM productos WHERE model= :currentmodel");
        $stmt->execute([':currentmodel'=>$currentModel]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        require 'functions.php';

        $errors=['name'=>false,'lastname'=>false,'dni'=>false,'phone'=>false,'email'=>false,'remail'=>false,'province'=>false,'localidad'=>false,'address'=>false,'addressnumber'=>false,'cp'=>false];
        /* Post new costumer to DB */
        //VALIDATING DATA
        $name='';
        $lastname='';
        $dni=0;
        $phone=0;
        $email='';
        $province='';
        $city='';
        $address='';
        $cp='';
        $product='';
        if(isset($_POST['submit'])){
            $depto = '';
            $onlyAZ='/^[a-zA-z\s]+$/';
            $onlyNum='/^[\d]+$/';
            if(isset($_POST['depto'])){
                $depto=trim($_POST['depto']);
            }

            if(isset($_POST['name'])){
                if($_POST['name']!==''&& preg_match($onlyAZ,$_POST['name'])&&strlen($_POST['name'])<40){
                $name = trim($_POST['name']);
                }
                else{
                $errors['name']=true;
                }
            }
            if(isset($_POST['lastname'])){
                if($_POST['lastname']!==''&& preg_match($onlyAZ,$_POST['lastname'])&&strlen($_POST['lastname'])<40){
                $lastname = trim($_POST['lastname']); 
                }
                else{
                $errors['lastname']=true;
                }
            }
            if(isset($_POST['dni'])){
                if($_POST['dni']!==''&& preg_match($onlyNum,$_POST['dni'])&&strlen($_POST['dni'])>6&&strlen($_POST['dni'])<9){
                $dni = trim($_POST['dni']); 
                }
                else{
                $errors['dni']=true;
                }
            }
            if(isset($_POST['phone'])){
                if($_POST['phone']!==''&& preg_match($onlyNum,$_POST['phone'])&&strlen($_POST['phone'])>=10&&strlen($_POST['phone'])<15){
                $phone = trim($_POST['phone']); 
                }
                else{
                $errors['phone']=true;
                }
            }
            if(isset($_POST['email'])&&isset($_POST['remail'])){
                if(trim($_POST['email'])===trim($_POST['remail'])){
                if($_POST['email']!==''&& filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $email = trim($_POST['email']); 
                }
                else{
                $errors['email']=true;
                }
            }else{
                $errors['remail']=true;
            }
            }

            if(isset($_POST['province'])){
                if($_POST['province']!==''&& preg_match($onlyAZ,$_POST['province'])&&strlen($_POST['province'])<20){
                $province = trim($_POST['province']); 
                }
                else{
                $errors['province']=true;
                }
            }
            if(isset($_POST['localidad'])){
                if($_POST['localidad']!==''&& preg_match($onlyAZ,$_POST['localidad'])&&strlen($_POST['localidad'])<20){
                $city = trim($_POST['localidad']); 
                }
                else{
                $errors['localidad']=true;
                }
            }
            if(isset($_POST['address'])){
                if($_POST['address']!==''&& preg_match($onlyAZ,$_POST['address'])&&strlen($_POST['address'])<20){
                $address = trim($_POST['address']); 
                }
                else{
                $errors['address']=true;
                }
            }
            if(isset($_POST['addressnumber'])){
                if($_POST['addressnumber']!==''&& preg_match($onlyNum,$_POST['addressnumber'])&&strlen($_POST['addressnumber'])<8){
                $address = $address . ' ' .trim($_POST['addressnumber']); 
                }
                else{
                $errors['addressnumber']=true;
                }
            }
            if(isset($_POST['cp'])){
                if($_POST['cp']!==''&&strlen($_POST['cp'])<8){
                $cp = trim($_POST['cp']); 
                }
                else{
                $errors['cp']=true;
                }
            }
            if(isset($_GET['color'])){
            $product = $result->id;
            $color = trim($_POST['color']);
        }
        $shouldInsertData=true;
        $stmt = $conn->prepare('INSERT INTO clientes(nombre, apellido, dni, telefono, email, provincia, localidad, direccion, codigopostal,product,color) VALUES (:nombre, :apellido, :dni, :telefono, :email, :provincia, :localidad, :direccion, :codigopostal, :product, :color)');
        foreach($errors as $error){
            if($error){
                $shouldInsertData = false;
            }
        }
        if($shouldInsertData){
            $stmt->execute([':nombre'=>$name,':apellido'=>$lastname,':dni'=>$dni,':telefono'=>$phone,':email'=>$email,':provincia'=>$province,':localidad'=>$city,':direccion'=>$address,':codigopostal'=>$cp,':product'=>$product,':color'=>$color]);
            //CREATING HASH ID
            $sql = 'SELECT LAST_INSERT_ID()';
            $query = $conn->query($sql);
            $res = $query->fetch(PDO::FETCH_ASSOC);
            $id=$res['LAST_INSERT_ID()'];
            $hashid = hash('md5',$res['LAST_INSERT_ID()']);
            $sql = "UPDATE clientes SET hashid = '$hashid' WHERE id='$id'";
            $conn->query($sql);
            //REDIRECT
            $redirect = "Location: confirma.php?o=".$hashid;
            $shouldRedirect=true;
        }
        }
    
    }
    if($shouldRedirect){
    header($redirect);
    }
    require "elements/header.php";
?>

<!DOCTYPE html>
<html>


<div class="breadcrumbs-wrapper">
    <div class="breadcrumbs">
        <span class="breadcrumbs-1"><a href="index.php">CATALOGO</a></span>
        <span>/</span>
        <span class="breadcrumbs-1"><a href="producto.php?model=<?php echo getQueryForGet($result); ?>"><?php echo $result->model; ?></a></span>
        <span>/</span>
        <span class="breadcrumbs-1">Checkout</span>
    </div>
</div>

<div class="form-wrapper">
    <form action="checkout.php?model=<?php echo $_GET['model'].'&color='.$_GET['color'] ?>" method='post'>
    <div class="div-title"><p>Tu Pedido</p></div>
        <div class="confirma-celular-wrapper">
                <div class="confirma-img-wrapper">
                    <img src="assets/phones/<?php echo getImageForUrl($result); ?>.png" alt="">
                </div>
                <div class="confirma-info-wrapper">
                <div class="confirma-title">
                    <?php echo $result->brand . ' ' . $result->model;?>
                </div>
                <div class="confirma-price">
                    $<?php echo number_format($result->price);?>
                </div>
                <div class="confirma-color">
                    <?php echo strtoupper($_GET['color']);?>
                </div>
                </div>
            </div>
        <div class="div-title"><p>Datos Personales</p></div>
        <div class="datos-personales">
            <label for="name">Nombre
            <input type="text" name="name" id="name" required value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>"> 
            <?php
            if($errors['name']){
            echo '<p class="error">Solo puede contener letras y su largo no puede superar 20.</p>';
            }
            ?>
            </label>
            <label for="lastname">Apellido
            <input type="text" name="lastname" id="lastname" required value="<?php if(isset($_POST['lastname'])){echo $_POST['lastname'];}?>">
            <?php
            if($errors['lastname']){
            echo '<p class="error">Solo puede contener letras y su largo no puede superar 20.</p>';
            }
            ?></label>
            <label for="dni">DNI
            <input type="text" name="dni" id="dni" required value="<?php if(isset($_POST['dni'])){echo $_POST['dni'];}?>">
            <?php
            if($errors['dni']){
            echo '<p class="error">DNI no válido</p>';
            }
            ?></label>
            <label for="phone">Telefono
            <input type="text" name="phone" id="phone" required value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>">
            <?php
            if($errors['phone']){
            echo '<p class="error">Teléfono no válido</p>';
            }
            ?></label>
            <label for="email">Email
            <input type="email" name="email" id="email" required value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
            <?php
            if($errors['email']){
            echo '<p class="error">Email no válido</p>';
            }
            ?>
        </label>
            <label for="remail">Repetir Email
            <input type="email" name="remail" id="remail" required value="<?php if(isset($_POST['remail'])){echo $_POST['remail'];}?>">
            <?php
            if($errors['remail']){
            echo '<p class="error">Los emails deben coincidir</p>';
            }
            ?></label>
        </div>
        <div class="div-title"><p>Envio</p></div>
        <div class="datos-envio">
            <label for="province">Provincia
            <input type="text" name="province" id="province" required value="<?php if(isset($_POST['province'])){echo $_POST['province'];}?>">
            <?php
            if($errors['province']){
            echo '<p class="error">Solo puede contener letras y su largo no puede superar 20.</p>';
            }
            ?></label>
            <label for="localidad">Localidad
            <input type="text" name="localidad" id="localidad" required value="<?php if(isset($_POST['localidad'])){echo $_POST['localidad'];}?>">
            <?php
            if($errors['localidad']){
            echo '<p class="error">Solo puede contener letras y su largo no puede superar 20.</p>';
            }
            ?></label>
            <label for="address">Direccion
            <input type="text" name="address" id="address" required value="<?php if(isset($_POST['address'])){echo $_POST['address'];}?>">
            <?php
            if($errors['address']){
            echo '<p class="error">Solo puede contener letras y su largo no puede superar 20.</p>';
            }
            ?></label>
            <label for="addressnumber">Nº
            <input type="text" name="addressnumber" id="addressnumber" required value="<?php if(isset($_POST['addressnumber'])){echo $_POST['addressnumber'];}?>">
            <?php
            if($errors['addressnumber']){
            echo '<p class="error">Numero no válido</p>';
            }
            ?></label>
            <label for="cp">Código Postal
            <input type="text" name="cp" id="cp" required value="<?php if(isset($_POST['cp'])){echo $_POST['cp'];}?>">
            <?php
            if($errors['cp']){
            echo '<p class="error">Valor no válido</p>';
            }
            ?></label>
            <label for="depto">Departamento
            <input type="text" name="depto" id="depto" value="<?php if(isset($_POST['depto'])){echo $_POST['depto'];}?>"></label>
        </div>
        <input type="hidden" value="<?php echo $_GET['brand']; ?>" name="brand">
        <input type="hidden" value="<?php echo $_GET['model']; ?>" name="model">
        <input type="hidden" value="<?php echo $_GET['color']; ?>" name="color">
        <input type="submit" class="submit-button" value="SIGUIENTE" name="submit">
    </form>
</div>


<?php
    require "elements/footer.php";
?>
</html>