<?php 
    require 'connection.php';
    if(isset($_POST['sactivate'])){
        $sql = "SELECT published FROM productos WHERE id='$_POST[activate]'";
        $query = $conn->query($sql);
        $result = $query->fetch(PDO::FETCH_OBJ);
        if($result->published){
            $sql = "UPDATE productos SET published = 0  WHERE id='$_POST[activate]'";
            $conn->query($sql);
            echo "true";
        }else{
            $sql = "UPDATE productos SET published = 1  WHERE id='$_POST[activate]'";
            $conn->query($sql);
        }
    }
    $sql = "SELECT * FROM productos";
    $query = $conn->query($sql);
    $result = $query->fetchAll(PDO::FETCH_OBJ);

?>

    <?php include 'header.php'; ?>
    <h2>List</h2>
    <?php foreach($result as $item): ?>
           <div class='card'>
           <p class='list-title'><?php echo $item->brand . ' ' . $item->model; ?> </p>

                <p class='list-price'>$<?php echo $item->price;?></p>

                <?php
                $isActivated='';
                $classColor = '';
                if($item->published){$isActivated='Deactivate';$classColor='red-text';}else{$isActivated="Activate";$classColor='green-text';}
                ?>

                <form action='edit.php' method='get'>
                    <input type='hidden' value="<?php echo $item->id;?>" name='product'>
                    <input type='submit' value='Edit' name="edit">
                </form>
                <form action='list.php' method='post'>
                    <input type='hidden' value="<?php echo $item->id; ?>" name='activate'>
                    <input type='submit' name='sactivate' class="<?php echo $classColor ;?>" value="<?php echo $isActivated; ?>">
                </form>


            </div>
    <?php endforeach;?>
    
    

</body>
</html>