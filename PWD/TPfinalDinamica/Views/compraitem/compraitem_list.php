<?php
require_once('../templates/preheader.php');
$objCompraItemCon = new CompraitemController();
try {
    $rol = $objSession->getRolPrimo();
    $lista = [];
    if($rol == 'Admin' || $rol == 'Deposito'){
        $arrBuCI = [];
        $list = $objCompraItemCon->listarTodo($arrBuCI);
    }else{
        //averiguar las compras del chabon
        $idusuario = $objSession->getIdusuario();
        if($idusuario != NULL){
            //averiguar la compra que tenga activa
            $objCompraCon = new CompraController();
            $idcompra = $objCompraCon->buscarCompraConIdusuario($idusuario);
            if($idcompra != NULL){
                //ver que la compra este iniciada 
                $objCompraestadoCon = new CompraestadoController();
                $return = $objCompraestadoCon->obtenerCompraActivaPorId($idcompra);
                //var_dump($return);
                if($return != false){
                    $arrBuCI = [];
                    $arrBuCI['idcompra'] = $return;
                    $list = $objCompraItemCon->listarTodo($arrBuCI);
                    //var_dump($list);
                }else{
                    $list = [];
                }
                
            }else{
                $list = [];
            }
        }
        if(count($list) > 0){
            foreach ($list as $key => $value) {
                $objProd = $value->getObjProducto();
                $objCompra = $value->getObjCompra();
                $arrDat = ['idcompraitem' => $value->getIdcompraitem(), 'idproducto' => $objProd->getIdproducto(), 'pronombre' => $objProd->getPronombre(), 'idcompra' => $objCompra->getIdcompra(), 'cicantidad' => $value->getCicantidad()];
                array_push($lista, $arrDat);
            }
        }
    }
} catch (\Throwable $th) {
    $rol = '';
    $lista = [];
}
/* $lista = $objCompraItem->listarTodo(); */

/** Con el id de usuario buscamos la compra que esté iniciada
 * Al id de compra se lo pasamos como parametro al array de busqueda de listarTodo de compraItem
 */
/* $objCompraController = new CompraController();

$idUsuario = $objSession->getIdusuario();
$idCompra =  $objCompraController->buscarCompraConIdusuario( $idUsuario );
$arrayBusqueda = ['idcompra' => $idCompra];
$lista = $objCompraItem->listarTodo( $arrayBusqueda ); */

?>

<div class="container-fluid p-5 my-1 d-flex justify-content-center compraitem">
    <div class="row">
        <div class="col-sm-12">

            <table id="dg" title="Administrador del carrito" class="easyui-datagrid" style="width:1200px;height:700px" url="accion/listar_compraitem.php" toolbar="#toolbar" pagination="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="idcompraitem" width="25">Id ítem</th>
                        <th field="idproducto" width="50">Id producto</th>
                        <th field="pronombre" width="50">Nombre producto</th>
                        <th field="idcompra" width="50">Id compra</th>
                        <th field="cicantidad" width="60">Cantidad comprada</th>
                    </tr>
                </thead>
            </table>
            <div id="toolbar">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editCantidad()">Editar cantidad</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyItem()">Eliminar ítem</a>
            </div>
            <div id="dlg" class="easyui-dialog" style="width:600px;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
                <form id="fm" method="POST" novalidate style="margin:0;padding:20px 50px;">
                    <h3>Pedido información</h3>
                    <div style="margin-bottom:10px;">
                        <input readonly name="idcompraitem" id="idcompraitem" class="easyui-textbox" required="true" label="N°ITEM" style="width:200px;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <input readonly name="idproducto" id="idproducto" class="easyui-textbox" required="true" label="ID PRODUCTO" style="width:200px;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <input readonly name="pronombre" id="pronombre" class="easyui-textbox" required="true" label="PRODUCTO" style="width:200px;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <input readonly name="idcompra" id="idcompra" class="easyui-textbox" required="true" label="N°COMPRA" style="width:200px;">
                    </div>
                    <div style="margin-bottom:10px;">
                        <input class="easyui-textbox" style="width:100px" name="cicantidad" id="cicantidad" required="true" label="CANTIDAD">
                        <p>Sólo puede modificar la cantidad</p>
                    </div>
                </form>
                <div id="dlg-buttons">
                    <a href="javascript:void(0)" class="easyui-button c6" iconCls="icon-ok" onclick="guardarProducto()" style="width:90px">Aceptar</a>
                    <a href="javascript:void(0)" class="easyui-button" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var url;
    /*
    function newProducto(){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo producto');
        $('#fm').form('clear');
        url='accion/insertar_producto.php';
    }
    */
    function editCantidad() {
        //dg es la tabla y getselect es el que esta seleccionado
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar cantidad');
            //traerme el stock con el id de producto (desp del = pongo el valor que me venga de la funcion d ecantidad)
            document.getElementById('cicantidad').max =
                $('#fm').form('load', row);
            url = 'accion/editarCantidad.php?idcompraitem=' + row.idcompraitem;
        }
    }

    function guardarProducto() {
        $('#fm').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                //alert('Volvio servidor');
                if (!result.respuesta) {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                } else {
                    $('#dlg').dialog('close');
                    $('#dg').datagrid('reload');
                }
            }
        })
    }

    function destroyItem() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('confirm', 'Seguro desea eliminar la compra?', function(r) {
                if (r) {
                    $.post('accion/destroy_compraitem.php?idcompraitem=' + row.idcompraitem, {
                        idcompraitem: row.id
                    }, function(result) {
                        //alert('Volvio servidor');
                        if (result.respuesta) {
                            $('#dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }, 'json');
                }
            })
        }
    }


    function StockSuficiente() {
        //dg es la tabla y getselect es el que esta seleccionado
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar cantidad');
            //traerme el stock con el id de producto
            $('#fm').form('load', row);
            url = 'accion/editarCantidad.php?idcompraitem=' + row.idcompraitem;
        }
    }
</script>

<style type="text/css">
    .compraitem {
        background-color: #006d31;
        color: white;
    }
</style>

<?php require_once('../templates/footer.php') ?>