<?php
/* Pagina error
 * Se despliega un mensaje de error informando de la causa que lo provocó.
 */
$pageTitle = "SIGII | Error";

include "includes/header_aplicacion.php";

?>
 <div class="container">          
        <div class="row">      
            <div class="span7 offset2">
              <div class="alert alert-error">
 
  <strong>Atenci&oacute;n!</strong> Hubo un error al realizar la acci&oacute;n :(<br/><br/>
  <strong>Error de <?php echo $_SESSION["error"]?></strong>. <?php echo $_SESSION["errormsg"]?>
</div>
<a href="<?php echo $_SESSION["pageFrom"]?>.php" class="btn btn-primary">Regresar</a>
<?php //unset($_SESSION["error"]);
//unset($_SESSION["errormsg"]);
//unset($_SESSION["pageFrom"]);?>
</div>
</div>
</div>
<?php 
include "includes/footer_principal.php";
 ?>