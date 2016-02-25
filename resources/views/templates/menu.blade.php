
<aside class="main-sidebar">
    <!-- <div class="bg-aside"></div> -->
    <section class="sidebar">
        <!-- Panel Usuario -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('fotos_personal/'.Session::get('usuario')[0]->s_RutaFotoPersonal) }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{Session::get('usuario')[0]->s_NombresPersonal}} {{Session::get('usuario')[0]->s_ApellidoPatPersonal}}</p>
                
            </div>
        </div>

        <!-- Menu de Navegacion -->
        <ul class="sidebar-menu">
            
            <li class="header">MENU DE NAVEGACION</li>

                <li data="principal" class="treeview menu-lvl-1">
                    <a href="main">
                        <i class="fa fa-home"></i>
                        <span>Pagina Inicial</span>
                    </a>
                </li>
                <li data="m_compras" class="treeview menu-lvl-1">
                    <a href="#">
                        <i class="fa fa-cart-plus"></i>
                        <span>Modulo de Compras</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li data="AdsComprobanteCompra_create" class="item-menu-1"><a href="AdsComprobanteCompra_create"> <i class="fa fa-file-o"></i> Factura de Compra</a></li>
                        <li data="AdsGuiaRemision_create_compra" class="item-menu-1"><a href="AdsGuiaRemision_create_compra"> <i class="fa fa-files-o"></i> Guia de Remision</a></li>
                        <li data="AdsComprobanteServicio_create" class="item-menu-1"><a href="AdsComprobanteServicio_create"> <i class="fa fa-file-o"></i> Factura de Servicio</a></li>
                        <li data="AdsComprobanteCompra" class="item-menu-1"><a href="AdsComprobanteCompra"> <i class="fa fa-question-circle"></i> Consultar Facturas</a></li>
                        <!-- <li data="AdsDetalleNota_createCompra" class="item-menu-1"><a href="AdsDetalleNota_createCompra"> <i class="fa fa-file-o"></i> Nota Crédito/Débito</a></li> -->
                        <li data="AdsDetalleNota_Compra" class="item-menu-1"><a href="AdsDetalleNota_Compra"> <i class="fa fa-question-circle"></i> Listado de Notas</a></li>
                        <li data="AdsGuiaRemision_compra" class="item-menu-1"><a href="AdsGuiaRemision_compra"> <i class="fa fa-question-circle"></i> Listado de Guias de Remisión</a></li>
                        <li data="AdsProveedor" class="item-menu-1"><a href="AdsProveedor"> <i class="fa fa-archive"></i> Proveedor</a></li>
                    </ul>
                </li>
                <li data="m_ventas" class="treeview menu-lvl-1">
                    <a href="#">
                        <i class="fa fa-credit-card"></i>
                        <span>Modulo de Ventas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li data="AdsProducto_Kardex_create" class="item-menu-1"><a href="AdsProducto_Kardex_create"> <i class="fa fa-folder-o"></i> Generar Kardex</a></li>
                        <li data="AdsComprobanteVenta_create" class="item-menu-1"><a href="AdsComprobanteVenta_create"> <i class="fa fa-file-o"></i> Factura de Venta</a></li>
                        <li data="AdsComprobanteVenta" class="item-menu-1"><a href="AdsComprobanteVenta"> <i class="fa fa-question-circle"></i> Consultar Facturas</a></li>
                        <!-- <li data="AdsDetalleNota_create" class="item-menu-1"><a href="AdsDetalleNota_create"> <i class="fa fa-file-o"></i> Nota Crédito/Débito</a></li> -->
                        <li data="AdsDetalleNota" class="item-menu-1"><a href="AdsDetalleNota"> <i class="fa fa-question-circle"></i> Listado de Notas</a></li>
                        <li data="PtvCliente" class="item-menu-1"><a href="PtvCliente"> <i class="fa fa-users"></i> Clientes</a></li>
                        <li data="AdsGuiaRemision_create" class="item-menu-1"><a href="AdsGuiaRemision_create"> <i class="fa fa-files-o"></i> Guia de Remision</a></li>
                        <li data="AdsTransporte" class="item-menu-1"><a href="AdsTransporte"> <i class="fa fa-truck"></i> Transporte</a></li>
                        <!-- <li data="m_ventas_transporte" class="menu-lvl-2">
                          <a href="#"><i class="fa fa-truck"></i> Transporte <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu item-menu">
                            <li data="AdsTransporte" class="item-menu-2"><a href="AdsTransporte"> <i class="fa fa-institution"></i> Empresa</a></li>
                            <li data="AdsPersonalTransporte" class="item-menu-2"><a href="AdsPersonalTransporte"> <i class="fa fa-male"></i> Personal </a></li>
                            <li data="AdsUnidadTransporte" class="item-menu-2"><a href="AdsUnidadTransporte"> <i class="fa fa-bus"></i> Unidad de Tranporte</a></li>
                          </ul>
                        </li> -->
                    </ul>
                </li>

                <li data="m_cobranzas" class="treeview menu-lvl-1">
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <span>Modulo de Cobranzas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li data="AdsDetallePago" class="item-menu-1"><a href="AdsDetallePago"> <i class="fa fa-file-o"></i> Seguimiento Letras</a></li>
                        <li data="AdsDetallePago_Contado" class="item-menu-1"><a href="AdsDetallePago_Contado"> <i class="fa fa-file-o"></i> Seguimiento Contado</a></li>
                    </ul>
                </li>

                <li data="ads_sistema" class="treeview menu-lvl-1">
                    <a href="#">
                        <i class="fa fa-folder-open"></i>
                        <span>Administracion Sistema</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li data="AdsProducto_CierreMensual" class="item-menu-1"><a href="AdsProducto_CierreMensual"> <i class="fa fa-folder-o"></i> Cierre Mensual</a></li>
                        <li data="#" class="item-menu-1"><a href="#"> <i class="fa fa-folder-o"></i> Tipo de Cambio</a></li>
                        <li data="AdsIgv" class="item-menu-1"><a href="AdsIgv"> <i class="fa fa-folder-o"></i> Igv del Sistema</a></li>
                        <li data="AdsProducto" class="item-menu-1"><a href="AdsProducto"> <i class="fa fa-folder-o"></i> Producto</a></li>
                        <li data="AdsUnidadMedida" class="item-menu-1"><a href="AdsUnidadMedida"> <i class="fa fa-folder-o"></i> Unidad de Medida</a></li>
                        <li data="AdsTipoComprobante" class="item-menu-1"><a href="AdsTipoComprobante"> <i class="fa fa-folder-o"></i> Tipo Comprobante</a></li>
                        <li data="AdsMotivoTraslado" class="item-menu-1"><a href="AdsMotivoTraslado"> <i class="fa fa-folder-o"></i> Motivo de Traslado</a></li>
                        <li data="AdsColor" class="item-menu-1"><a href="AdsColor"> <i class="fa fa-folder-o"></i> Color</a></li>
                    </ul>
                </li>

                <li data="m_reportes" class="treeview menu-lvl-1">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i>
                        <span>Reportes Generales</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li data="AdsComprobanteVenta_Reporte" class="item-menu-1"><a href="AdsComprobanteVenta_Reporte"> <i class="fa fa-file-o"></i> Reporte de Ventas</a></li>
                        <li data="AdsDetallePago_Reporte" class="item-menu-1"><a href="AdsDetallePago_Reporte"> <i class="fa fa-file-o"></i> Reporte de Letras</a></li>
                    </ul>
                </li>

                

        </ul>

        <ul class="sidebar-menu">

                
            </ul>
    </section>
</aside>

<script type="text/javascript">

function menu_location(url){
    window.location.href = url;
}

$(function(){
    var active_menu = sessionStorage.getItem("menu");
    var active_submenu = sessionStorage.getItem("submenu");
    var active_item_1 = sessionStorage.getItem("item_1");
    var active_item_2 = sessionStorage.getItem("item_2");

    $.each($(".menu-lvl-1"), function(key, value){
        if(!$(this).hasClass("menu-lvl-2")) {
            if ($(value).attr("data") == active_menu) {
                $(value).addClass("active");
                if(!$(value).find("ul").hasClass("item-menu")){
                    $(value).find("ul").css("display", "block");
                }
            }
            
        } 
    });

    $.each($(".item-menu-1"), function(key, value){
        if ($(value).attr("data") == active_item_1) {
            $(value).addClass("active");
        }
    });

    $.each($(".menu-lvl-2"), function(key, value){
        if ($(value).attr("data") == active_submenu) {
            $(value).addClass("active");
            $(value).find("ul").css("display", "block");
        }
    });


    $.each($(".item-menu-2"), function(key, value){
        if ($(value).attr("data") == active_item_2) {
            $(value).addClass("active");
        }
    });

    $(".menu-lvl-1").on("click", function(){
        if(!$(this).hasClass("active")) {
            sessionStorage.setItem("menu", $(this).attr("data"));
            sessionStorage.setItem("submenu", $(this).attr(""));
        }  
    });

    $(".item-menu-1").on("click", function(){
        if(!$(this).hasClass("active")) {
            sessionStorage.setItem("item_1", $(this).attr("data"));
            sessionStorage.setItem("submenu", $(this).attr(""));
            sessionStorage.setItem("item_2", $(this).attr(""));
            // sessionStorage.setItem("submenu", '');
        }  
    });

    $(".menu-lvl-2").on("click", function(){
        if(!$(this).hasClass("active")) {
            sessionStorage.setItem("submenu", $(this).attr("data"));
        }  
    });

    $(".item-menu-2").on("click", function(){
        if(!$(this).hasClass("active")) {
            sessionStorage.setItem("item_2", $(this).attr("data"));
            sessionStorage.setItem("item_1", $(this).attr(""));
            // sessionStorage.setItem("submenu", '');
        }  
    });
    
    // $(".menu-lvl-2 .item-menu").on("click", function(){
    //     if(!$(this).hasClass("active")) {
    //         sessionStorage.setItem("item", $(this).attr("data"));
    //     }  
    // });
    
});  

</script>