<?php
    $gracias = false;
    if(isset($_POST['submit'])){
        $gracias = true;
    }

?>
<!DOCTYPE html>
<html>
    <?php
    
    require "elements/header.php";
    require 'functions.php';
    ?>
    <?php if($gracias){
        echo "<p class='message'>Gracias por contactarte</p>";

    }else{



    echo '
    <h1 class="page-title">Contactanos</h1>
    <form action="contact.php" method="post" class="form-wrapper contact">
    
    <label for="nombre"> Tu nombre
        <input type="text" name="nombre"  id="nombre" required>
    </label>
    <label for="email"> Email
        <input type="email" name="email"  id="email" required>
    </label>
    <label for="comunicado"> Tu consulta
       <textarea name="comunicado" id="comunicado"  required></textarea>
    </label>
        <input type="submit" class="submit-button" name="submit">
    </form>
    ';
    }
    ?>


    <?php
        require "elements/footer.php";
    ?>
</html>