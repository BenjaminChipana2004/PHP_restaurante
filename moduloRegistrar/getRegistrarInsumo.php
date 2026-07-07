<?php
function validarCasillas($cod, $stock, $lote)
{
    return (!empty($cod) && is_numeric($stock) && is_numeric($lote));
}

function validarBotonRegistrar($boton)
{
    return isset($boton);
}

// Capturamos los datos que coinciden con DB_Insumo
$codInsumo = trim($_POST['txtCodInsumo']);
$stock = trim($_POST['txtStock']);
$loteId = trim($_POST['txtLoteId']);
$boton = $_POST['btnRegistrarInsumo'];

if (!validarBotonRegistrar($boton)) {
    include_once('../shared/mensajeSistemaBox.php');
    $objMensaje = new mensajeSistemaBox();
    $objMensaje->mensajeSistemaBoxShow("ERROR: Operación no permitida", "<a href='../moduloSeguridad/getUsuario.php'>Regresar al panel</a>");
} else {
    if (!validarCasillas($codInsumo, $stock, $loteId)) {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje->mensajeSistemaBoxShow("ERROR: Los datos del insumo son inválidos", "<a href='javascript:history.back()'>Volver a intentar</a>");
    } else {
        include_once('controllerRegistrarInsumo.php');
        $objControl = new controllerRegistrarInsumo();

        // 1. Enviar Insumo a la base de datos (con su lote respectivo)
        $objControl->enviarInsumo($codInsumo, $stock, $loteId);
        
        // 2. Obtener el stock refrescado
        $listaActualizada = $objControl->obtenerStock();

        // 3. Mostrar de nuevo la interfaz inicial con la tabla actualizada
        include_once('formRegistrarInsumo.php');
        $objForm = new formRegistrarInsumo();
        $objForm->formRegistrarInsumoShow($listaActualizada, false);
    }
}
?>