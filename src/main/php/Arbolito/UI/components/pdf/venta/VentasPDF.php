<?php

namespace Arbolito\UI\components\pdf\venta;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Datetime;

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

use Arbolito\Core\model\EstadoVenta;


/**
 * para renderizar en pdf listado de ventas.
 *
 * @author Marcos
 * @since 16-03-2022
 *
 */
class VentasPDF extends RastyComponent{



	public function getType(){

		return "VentasPDF";

	}

	public function __construct(){


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
			switch ($ventaCriteria->getFiltroPredefinido()) {
				case 'ventasHoy':

					$filtros .= ' ' . $this->localize("venta.filter.hoy");
					break;
				case 'ventasSemanaActual':

					$filtros .= ' ' . $this->localize("venta.filter.semanaActual");
					break;
				case 'ventasMesActual':

					$filtros .= ' ' . $this->localize("venta.filter.mesActual");
					break;
				case 'ventasAnioActual':

					$filtros .= ' ' . $this->localize("venta.filter.anioActual");
					break;
				case 'ventasAnioActual':

					$filtros .= ' ' . $this->localize("venta.filter.anioActual");
					break;
				case 'ventasImpagas':

					$filtros .= ' ' . $this->localize("venta.filter.impagas");
					break;
				case 'ventasAnuladas':

					$filtros .= ' ' . $this->localize("venta.filter.anuladas");
					break;
				default:
					$filtros .= ' ' . $ventaCriteria->getFiltroPredefinido();
			}
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


		$ventas = \Arbolito\UI\service\UIServiceFactory::getUIVentaService()->getList($ventaCriteria);
		//print_r($ventas);
		foreach ($ventas as $venta) {

			$xtpl->assign( "fechaHora", ArbolitoUIUtils::formatDateTimeToView($venta->getFecha()) );
			$xtpl->assign( "nroComprobante", $venta->getNroComprobante() );
			$xtpl->assign( "cliente", $venta->getCliente() );
			$detalles ='';

			foreach ($venta->getDetalles() as $detalle) {
				$detalles .=$detalle->getProducto().' ';
			}

			$xtpl->assign( "detalles", $detalles);

			$xtpl->assign( "monto", ArbolitoUIUtils::formatMontoToView( $venta->getMonto() ) );
			$xtpl->assign( "montoPagado", ArbolitoUIUtils::formatMontoToView( $venta->getMontoPagado() ) );
			$xtpl->assign( "montoDebe", ArbolitoUIUtils::formatMontoToView( $venta->getMontoDebe() ) );
			$xtpl->assign( "observaciones", $venta->getObservaciones() );
			$xtpl->assign( "estado", $this->localize( EstadoVenta::getLabel( $venta->getEstado() ) ));

			$xtpl->parse( "main.ventas.detalle" );


		}
		if ($ventas) {
			$xtpl->parse( "main.ventas" );
		}









	}







	public function getPDFRenderer(){

		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
