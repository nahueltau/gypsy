<!DOCTYPE html>
<html>
    <?php
    
    require "elements/header.php";
    require 'functions.php';
    require "controlpanel/connection.php";
    $result = [];
    if(isset($_GET['categoria'])){
        if($_GET['categoria']==='all'){
            header('location: /');
        }
        $stmt = $conn->prepare("SELECT * FROM productos WHERE published=1 AND category=:category");
        $stmt->execute([':category'=>$_GET['categoria']]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif(isset($_GET['search'])){
        $stmt = $conn->prepare("SELECT * FROM productos WHERE published=1 AND model LIKE :model");
        $model = '%'. $_GET['search'] .'%';
        $stmt->execute([':model'=>$model]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ); 

    }else{
    $sql = "SELECT * FROM productos WHERE published=1";
    $query = $conn->query($sql);
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    }
    $count = count($result);
    /* GET CATEGORIES FOR CATEGORY SELECTOR */
    $sql = "SELECT category FROM productos WHERE published=1";
    $query = $conn->query($sql);
    $category = $query->fetchAll(PDO::FETCH_OBJ);
    $categories = [];
    foreach($category as $res){
        $categories[]= $res->category;
    }
    $categories = array_unique($categories);

    ?>
    <div class="billboard-wrapper">
        <img src="assets/banner_s.jpg" alt="">
    </div>

    <div class="benefits-bar">
        <div class="benefits-bar-item">
            <img class="benefits-bar-icon" src="assets/envio_blue.png" alt="">
            <h4>ENVIOS GRATIS</h4>
        </div>
        <div class="benefits-bar-item">
            <img class="benefits-bar-icon" src="assets/card_blue.png" alt="">
            <h4>PAGA CON TARJETA</h4>
        </div>
    </div>
    <div class="main-content">
        <div class="category-bar">
            <form action="index.php" class="category-form">
            <select name="categoria" id="">
                <option value="all" onclick="selectCategory()">Categorias</option>
                <optgroup Label="Celulares">
                <?php foreach($categories as $category):?>
                  <option value="<?php echo strtolower($category);?>" name="<?php echo $category;?>"  onclick="selectCategory('<?php echo strtolower($category);?>')"><?php echo $category;?></option>
                <?php endforeach; ?>
                </optgroup>
            </select>
            <input type="submit" value="Ir" class="submit-button-category">
        </form>
        </div>
        <?php
 if(count($result)===0){
                echo "<p class='message'>No encontramos resultados para tu busqueda :(</p>";
            }?>
        <div class="catalog-wrapper">
            <?php
            /* PAGINATION SETUP */
            $index=0;
            $indexcap = 0;
            if(isset($_GET['page'])){
                $index = (intval(htmlspecialchars($_GET['page']))-1)*9;
                $indexcap = $index;
                if($index>count($result)){
                    header("location: index.php");
                }
            }
            /*  RENDER CATALOG ITEMS  */
            for($index;($index<count($result))&&($index<$indexcap+9);$index++):?>
                <div class="catalog-item">
                <div class="catalog-img-wrapper">
                    <img src="assets/phones/<?php echo getImageForUrl($result,$index); ?>.png" alt="">
                </div>
                <div class="catalog-brand"><?php echo $result[$index]->brand ?></div>
                <div class="catalog-model"><?php echo $result[$index]->model ?></div>
                <div class="catalog-price">$<?php echo number_format($result[$index]->price); ?></div>
                <div class="catalog-cta"><a href="producto.php?model=<?php echo getQueryForGet($result,$index)?>"><button>Comprar</button></a></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    
    <?php
    /* PAGINATION DISPLAY SETUP */
    $currentPage = $indexcap/9+1;
    ?>
    <div class="pagination-wrapper">
            <div class="pagination-button <?php if($indexcap<1){echo 'pagination-hidden';}?>">
               <a href="index.php?page=<?php echo $currentPage-1;?>">Anterior</a>
            </div>
            <?php for($i=0;$i<count($result)/9;$i++):?>
            <a href="index.php?page=<?php echo $i+1;?>"><div class="pagination-number <?php if($currentPage===$i+1){echo 'pagination-active';}else{echo 'pagination-inactive';}?>">
               <?php echo $i+1;?>
            </div></a> 
            <?php endfor;?>   
            <div class="pagination-button <?php if($currentPage>=count($result)/9){echo 'pagination-hidden';}?>">
            <a href="index.php?page=<?php echo $currentPage+1;?>">Siguiente</a>
            </div>
    </div>


    <?php
        require "elements/footer.php";
    ?>
</html>