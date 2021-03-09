<?php
    if(isset($_POST['submit'])){
        $username = $_POST['name'];
        $pwd = hash('gost-crypto',$_POST['pwd']);
        require "connection.php";
        $stmt = $conn->prepare("SELECT * FROM admins WHERE user=:user AND pass=:pass");
        $stmt->execute([':user'=>$username,':pass'=>$pwd]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if (isset($result->user)){
            $token = bin2hex(random_bytes(10));
            $tokenhash = hash('gost-crypto',$token);
            $userid = $result->id;
            setcookie("token",$token);
            setcookie("username",$username);
            $stmt = $conn->prepare("UPDATE admins SET token=:token WHERE id=:id");
            $stmt->execute([':token'=>$tokenhash,':id'=>$userid]);
            header("location: index.php");
        }
    
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Control Panel</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
    <div class="coontainer">
        <form action="login.php" method="post">
            <div class="form-group">
            <input type="text" name="name">
            </div>
            <div class="form-group">
            <input type="password" name="pwd">
            </div>
            <div class="form-group">
            <input type="submit" name="submit" value="">
            </div>
        </form>
    </div>

</body>
</html>