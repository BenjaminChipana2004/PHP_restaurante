<?php
function validarCasillas($id, $nombre, $cantidad, $categoria)
{
    // Valida que los campos obligatorios cumplan con una longitud mínima
    return (strlen($id) >= 2 && strlen($nombre) >= 3 && intval($cantidad) > 0 && strlen($categoria) >= 3);
}

function validarBotonRegistrar($boton)
{
    return isset($boton);
}

$id = trim($_POST['txtIdInsumo']);
$nombre = trim($_POST['txtNombre']);
$cantidad = trim($_POST['txtCantidad']);
$categoria = trim($_POST['txtCategoria']);
$boton = $_POST['btnRegistrarInsumo'];

if (!validarBotonRegistrar($boton)) {
    include_once('../shared/mensajeSistemaBox.php');
    $objMensaje = new mensajeSistemaBox();
    $objMensaje->mensajeSistemaBoxShow("ERROR: Operación no permitida", "<a href='../moduloSeguridad/getUsuario.php'>Regresar al panel</a>");
} else {
    if (!validarCasillas($id, $nombre, $cantidad, $categoria)) {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje->mensajeSistemaBoxShow("ERROR: Los datos del insumo son inválidos o están incompletos", "<a href='javascript:history.back()'>Volver a intentar</a>");
    } else {
        include_once('ControllerRegistrarInsumo.php');
        $objControl = new ControllerRegistrarInsumo();

        // Secuencia Estricta del Diagrama:
        // 1. Enviar Insumo
        $objControl->enviarInsumo($id, $nombre, $cantidad, $categoria);
        
        // 2. Actualizar Stock
        $objControl->actualizarStock($id, $cantidad);
        
        // 3. Obtener el stock refrescado
        $listaActualizada = $objControl->obtenerStock();

        // 4. Mostrar de nuevo la interfaz inicial con la tabla actualizada
        include_once('formRegistrarInsumo.php');
        $objForm = new formRegistrarInsumo();
        $objForm->formRegistrarInsumoShow($listaActualizada, false);
    }
}
?>