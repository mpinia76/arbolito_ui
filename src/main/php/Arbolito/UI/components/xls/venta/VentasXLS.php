<?php

namespace Arbolito\UI\components\xls\venta;

use Datetime;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Arbolito\UI\components\filter\model\UIVentaCriteria;

use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;
use Rasty\factory\PageFactory;

use Rasty\utils\Logger;


/**
 * para renderizar en xls los ventas
 *
 * @author Marcos
 * @since 16-03-2022
 *
 */
class VentasXLS extends RastyComponent{



	public function getType(){

		return "VentasXLS";

	}

	public function __construct(){


	}

	public function getFileName(){
		"cuotas";

	}


	protected function parseXTemplate(XTemplate $xtpl){

		$page = PageFactory::build("Ventas");

		$ventaCriteria = new UIVentaCriteria();

		$ventaFilter = $page->getComponentById("ventasFilter");

		$ventaFilter->fillFromSaved($ventaCriteria);
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		$xtpl->assign( "fecha", ArbolitoUIUtils::formatDateTimeToView(new Datetime()) );




		if ($ventaCriteria->getFechaDesde()&&$ventaCriteria->getFechaHasta()){
			$xtpl->assign( "entreFechas", 'Entre las fechas '.ArbolitoUIUtils::formatDateToView($ventaCriteria->getFechaDesde()).' y '.ArbolitoUIUtils::formatDateToView($ventaCriteria->getFechaHasta()));
		}

		$filtros='';
		if ($ventaCriteria->getNroComprobante()){
			$filtros .='Nro. Recibo: '.$ventaCriteria->getNroComprobante();
		}
		if ($ventaCriteria->getCliente()){
			$filtros .=' Socio: '.$ventaCriteria->getCliente();
		}
		if ($ventaCriteria->getObservaciones()){
			$filtros .=' Observaciones: '.$ventaCriteria->getObservaciones();
		}
		if ($ventaCriteria->getFiltroPredefinido()){
			$filtros .=' '.$this->localize($ventaCriteria->getFiltroPredefinido());
		}

		$xtpl->assign("filtros", $filtros );

		$xtpl->assign("lbl_fecha", $this->localize( "venta.fecha" ) );
		$xtpl->assign("lbl_nroComprobante", $this->localize( "venta.nroComprobante" ) );
		$xtpl->assign("lbl_cliente", $this->localize( "venta.cliente" ) );
		$xtpl->assign("lbl_detalles", $this->localize( "venta.detalles" ) );
		$xtpl->assign("lbl_monto", $this->localize( "venta.monto" ) );
		$xtpl->assign("lbl_montoPagado", $this->localize( "venta.montoPagado" ) );
		$xtpl->assign("lbl_montoDebe", $this->localize( "venta.montoDebe" ) );
		$xtpl->assign("lbl_observaciones", $this->localize( "venta.observaciones" ) );
		$xtpl->assign("lbl_estado", $this->localize( "venta.estado" ) );


		$ventas = UIServiceFactory::getUIVentaService()->getList($ventaCriteria);
		//print_r($ventas);
		/*foreach ($ventas as $venta) {

			$xtpl->assign( "fechaHora", ArbolitoUIUtils::formatDateTimeToView($venta->getFechaHora()) );
			$xtpl->assign( "nroComprobante", $venta->getNroComprobante() );
			$xtpl->assign( "cliente", $venta->getCliente() );
			$xtpl->assign( "detalles", $venta->getDetalles() );

			$xtpl->assign( "monto", ArbolitoUIUtils::formatMontoToView( $venta->getMonto() ) );
			$xtpl->assign( "montoPagado", ArbolitoUIUtils::formatMontoToView( $venta->getMontoPagado() ) );
			$xtpl->assign( "montoDebe", ArbolitoUIUtils::formatMontoToView( $venta->getMontoDebe() ) );
			$xtpl->assign( "observaciones", $venta->getObservaciones() );
			$xtpl->assign( "estado", $venta->getEstado() );

			$xtpl->parse( "main.ventas.detalle" );


		}*/
		if ($ventas) {
			$xtpl->parse( "main.ventas" );
		}




	}








}
?>
