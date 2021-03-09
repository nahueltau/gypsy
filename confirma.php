<!DOCTYPE html>
<html>
<?php
    require "elements/header.php";
    require "functions.php";
    if(isset($_GET['o'])){
    require "controlpanel/connection.php";
    $stmt = $conn->prepare('SELECT * FROM clientes WHERE hashid = :hashid');
    $stmt->execute([':hashid'=>$_GET['o']]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    $sql = "SELECT * FROM productos WHERE id='$data->product'";
    $query = $conn->query($sql);
    $result = $query->fetch(PDO::FETCH_OBJ);
    }

    // SDK de Mercado Pago
    require __DIR__ .  '/vendor/autoload.php';

    // Agrega credenciales
    $accessToken = '++++++++++++++++++++++++++++++++++++++++++++++++++++++++';
   
    MercadoPago\SDK::setAccessToken($accessToken);

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    // Crea un ítem en la preferencia
    $item = new MercadoPago\Item();
    $item->title = $result->brand . ' ' . $result->model . ' ' . $data->color;
    $item->quantity = 1;
    $item->unit_price = $result->price;

    $item->id = $_GET['o'];
    $item->currency_id = "ARS";

    $preference->items = array($item);
    $preference->save();

    $payer = new MercadoPago\Payer();
    $payer->name = $data->name;
    $payer->surname = $data->lastname;
    $payer->email = $data->email;
    $payer->date_created = $data->date;
    $payer->phone = array(
         "number" => $data->phone
    );
  
    $payer->identification = array(
        "type" => "DNI",
        "number" => $data->dni
     );
  
     $payer->address = array(
        "street_name" => $data->codigopostal,
        "street_number" => $data->addressnumber,
        "zip_code" => $data->codigopostal
    );


?>

<div class="breadcrumbs-wrapper">
    <div class="breadcrumbs">
        <span class="breadcrumbs-1"><a href="index.php">CATALOGO</a></span>
        <span>/</span>
        <span class="breadcrumbs-1"><a href="producto.php?model=<?php echo getQueryForGet($result); ?>"><?php echo $result->model; ?></a></span>
        <span>/</span>
        <span class="breadcrumbs-1"><a href="checkout.php?color=<?php echo $data->color . '&model=' . getQueryForGet($result); ?>"> Checkout</a></span>
        <span>/</span>
        <span class="breadcrumbs-1">Pagar</span>
    </div>
</div>

<div class="form-wrapper">
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
            <?php echo strtoupper($data->color);?>
        </div>
        </div>
    </div>
<div class="div-title"><p>Confirmar Datos</p></div>
    <div class="confirma-datos-wrapper">
        <div class="confirma-dato">
            Nombre: <strong> <?php echo $data->nombre . ' ' . $data->apellido; ?></strong>
        </div>
        <div class="confirma-dato">
            DNI:<strong> <?php echo $data->dni; ?></strong>
        </div>
        <div class="confirma-dato">
            Teléfono:<strong> <?php echo $data->telefono; ?></strong>
        </div>
        <div class="confirma-dato">
            Email:<strong> <?php echo $data->email; ?></strong>
        </div>
        <div class="confirma-dato">
            Localidad:<strong> <?php echo $data->localidad . ', ' . $data->provincia; ?></strong>
        </div>
        <div class="confirma-dato">
            Dirección:<strong> <?php echo $data->direccion; ?></strong>
        </div>
        <div class="confirma-dato">
            Código Postal:<strong> <?php echo $data->codigopostal; ?></strong>
        </div>
            <form action="/procesar-pago" method="POST">
    <script
        src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
        data-preference-id="<?php echo $preference->id; ?>">
    </script>
    </form>
    </div>


</div>


<?php
    require "elements/footer.php";
?>
</html>