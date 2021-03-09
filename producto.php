<?php
    require "elements/header.php";
    if(isset($_GET['model'])){
        require "controlpanel/connection.php";
        $addSapces = str_replace('_',' ',$_GET['model']);
        $currentModel = str_replace('-','.',$addSapces);
        
        $sql = "SELECT * FROM productos WHERE model='$currentModel'";
        $query = $conn->query($sql);
        $result = $query->fetch(PDO::FETCH_OBJ);

        $keyspecs = explode(',',$result->keyspecs);
        $colornames = explode(',',$result->colorname);
        $colorcodes = explode(',',$result->colorcode);
        require 'functions.php';
    }

?>
<!DOCTYPE html>
<html>

<div class="breadcrumbs-wrapper">
    <div class="breadcrumbs"><span class="breadcrumbs-1"><a href="/">CATALOGO</a></span><span>/</span><span class="breadcrumbs-1"><?php echo $result->brand . ' ' . $result->model;?></span></div>
</div>
<div class="product-wrapper">
    <div class="img-wrapper">
        
            <div class="img-thumb-wrapper">
                <div class="img-arrow-container-left" onclick="arrowGetView(0)"><span onclick="arrowGetView(0)" class="material-icons">keyboard_arrow_left</span></div>
                <div class="img-thumb">
                <?php for($i=0;$i<count($colornames);$i++): /* CREATE IMAGE THUMBS */?>
                    
                    <img onclick="getView(event,'<?php echo $colornames[$i] ;?>')" src="<?php echo getImgSrc($result,$colornames,$i); ?>-front.png" alt="" <?php echo "class='" . $colornames[$i] . "-display-img'"; if($i==0){echo "style='display:inline;'";}else{echo "style='display:none;'";} ?>>
                    <?php endfor; ?>
                </div>
                <div class="img-thumb">
                <?php for($i=0;$i<count($colornames);$i++): /* CREATE IMAGE THUMBS */?>
                    <img onclick="getView(event,'<?php echo $colornames[$i] ;?>')" src="<?php echo getImgSrc($result,$colornames,$i); ?>-back.png" alt="" <?php echo "class='" . $colornames[$i] . "-display-img'"; if($i==0){echo "style='display:inline;'";}else{echo "style='display:none;'";} ?>>
                    <?php endfor; ?>
                </div>
                <div class="img-thumb">
                <?php for($i=0;$i<count($colornames);$i++): /* CREATE IMAGE THUMBS */?>
                    <img onclick="getView(event,'<?php echo $colornames[$i] ;?>')" src="<?php echo getImgSrc($result,$colornames,$i); ?>-side.png" alt="" <?php echo "class='" . $colornames[$i] . "-display-img'"; if($i==0){echo "style='display:inline;'";}else{echo "style='display:none;'";} ?>>
                    <?php endfor; ?>
                </div>
                <div class="img-arrow-container-right" onclick="arrowGetView(1)"><span onclick="arrowGetView(1)" class="material-icons">keyboard_arrow_right</span></div>

            </div>
            <div class="main-img">

                <?php for($i=0;$i<count($colornames);$i++): /* CREATE MAIN IMAGE */?>

                 <img src="<?php echo getImgSrc($result,$colornames,$i); ?>-front.png" alt="" <?php echo "class='" . $colornames[$i] . "-display-img current-view'"; if($i==0){echo "style='display:inline;'";}else{echo "style='display:none;'";} ?>>
                <?php endfor; ?>
            </div>
        
    </div>
    <div class="info-wrapper">
        <div class="info-title">
            <?php echo $result->brand . ' ' . $result->model;?>
        </div>
        <div class="info-price">
            $<?php echo number_format($result->price);?>
        </div>
        <div class="info-message">Busca las promociones y cuotas sin interes que dispones con las diferentes tarjetas. <a href="https://www.mercadopago.com.ar/cuotas">Mas informacion</a></div>
        <div class="color-select-wrapper">
            <p>Color</p>
            <form action="checkout.php" method="get">
                <div class="color-label-wrapper">
                    <?php
                    /* CREATE COLOR LABELS */
                    for($i = 0;$i<count($colornames);$i++): ?>
                    <label for="<?php echo $colornames[$i];?>" onclick="<?php echo "rotateColors('" . getRotateColorsAttributes($colornames,$i) . "')" ;?>">
                        <input type="radio" id="<?php echo $colornames[$i];?>" value="<?php echo strtolower($colornames[$i]);?>" name="color" <?php if($i==0){echo "checked";} ?> >
                        <div class="color-radio-wrapper"><span class="color-radio" style="background-color: <?php echo $colorcodes[$i];?>;"></span></div>
                    </label>
                    <?php endfor; ?> 
                </div>
                <div class="cta-comprar">
                <input type="hidden" name="model" value="<?php echo getQueryForGet($result);?>">
                <input type="submit" class="button-comprar" value="COMPRAR">
                </div>
            </form>
        </div>
       
        <div class="info-benefits-wrapper">
            <div><img src="assets/desbloqueado.svg" alt=""><p>¡EQUIPO LIBERADO! Apto para todas las compañías.</p> </div>
            <div><img src="assets/garantia.svg" alt=""><p>GARANTIA OFICIAL DEL FABRICANTE por 12 meses.</p></div>
        </div>
    </div>
</div>
<div class="specs-wrapper">
    <div class="div-title"><p>Espicificaciones Principales</p></div>
    <div class="main-specs-wrapper">
        <div class="main-spec">
            <img src="assets/pdp_pantalla.png" alt="">
            <div>
                <small>Pantalla</small>   
                <p><?php echo $keyspecs[0];?></p>
            </div>
        </div>
    
        <div class="main-spec">
            <img src="assets/pdp_ram.png" alt="">
            <div>
                <small>Sistema Operativo</small>   
                <p><?php echo $keyspecs[1];?></p>
            </div>
        </div>
   
        <div class="main-spec">
            <img src="assets/pdp_memoriainterna.png" alt="">
            <div>
                <small>Memoria Interna</small>   
                <p><?php echo $keyspecs[2];?></p>
            </div>
        </div>
  
        <div class="main-spec">
            <img src="assets/pdp_camara.png" alt="">
            <div>
                <small>Camara</small>   
                <p><?php echo $keyspecs[3];?></p>
            </div>
        </div>

        <div class="main-spec">
            <img src="assets/pdp_procesador.png" alt="">
            <div>
                <small>Procesador</small>   
                <p><?php echo $keyspecs[4];?></p>
            </div>
        </div>

        <div class="main-spec">
            <img src="assets/pdp_compatibilidad.png" alt="">
            <div>
                <small>Compatibilidad</small>   
                <p><?php echo $keyspecs[5];?></p>
            </div>
        </div>
    </div>
    <p class="specs-external">Podes ver las especificaciones completas en la página del fabricante! <a href="<?php echo $result->web ?>">Link.</a> </p>
</div>


<?php
    require "elements/footer.php";
?>
</html>