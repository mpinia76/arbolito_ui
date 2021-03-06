<?php

namespace Arbolito\UI\components\pdf\presupuesto;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Arbolito\Core\model\Presupuesto;

use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;

/**
 * para renderizar en pdf la plantilla de contrato
 * de un presupuesto.
 *
 * @author Marcos
 * @since 01-04-2019
 *
 */
class PresupuestoPDF extends RastyComponent{

	private $presupuesto;

	public function getType(){

		return "PresupuestoPDF";

	}

	public function __construct(){


	}


	protected function parseXTemplate(XTemplate $xtpl){

		$presupuesto = $this->getPresupuesto();
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		if( !empty($presupuesto )){

			/*$contrato = html_entity_decode( $presupuesto->getDetalleFalla() );

			$xtpl->assign("contrato",  $contrato );*/
			$xtpl->assign( "oid", $presupuesto->getOid() );
			$xtpl->assign( "fecha", ArbolitoUIUtils::formatDateTimeToView($presupuesto->getFecha()) );
			$observaciones = ($presupuesto->getObservaciones())?' - '.$presupuesto->getObservaciones():'';
			$xtpl->assign( "cliente", $presupuesto->getCliente().$observaciones);
			$xtpl->assign( "celular", $presupuesto->getCliente()->getCelular() );
			$xtpl->assign( "telefono", $presupuesto->getCliente()->getTelefono() );
			$xtpl->assign( "email", $presupuesto->getCliente()->getMail() );

			$xtpl->assign("lbl_detalle_nombre", $this->localize( "presupuesto.detalle.producto" ) );
			$xtpl->assign("lbl_detalle_precio", $this->localize( "presupuesto.detalle.precio" ) );
			$xtpl->assign("lbl_detalle_cantidad", $this->localize( "presupuesto.detalle.cantidad" ) );
			$xtpl->assign("lbl_detalle_subtotal", $this->localize( "presupuesto.detalle.subtotal" ) );

			$xtpl->assign("lbl_totales",  $this->localize( "presupuesto.detalles.total" ) );

			$cantidadTotal = 0;
			foreach ($presupuesto->getDetalles() as $detalle) {
				$xtpl->assign( "producto", $detalle->getProducto() );
				$xtpl->assign( "cantidad", $detalle->getCantidad() );
				$xtpl->assign( "precio", ArbolitoUIUtils::formatMontoToView( $detalle->getPrecioUnitario() ) );
				$xtpl->assign( "subtotal", ArbolitoUIUtils::formatMontoToView( $detalle->getSubtotal() ) );
				$xtpl->parse( "main.detalle" );

				$cantidadTotal += $detalle->getCantidad();
			}

			$xtpl->assign( "total", ArbolitoUIUtils::formatMontoToView( $presupuesto->getMonto() ) );
			$xtpl->assign( "cantidad_total", $cantidadTotal );



		}else{
			$xtpl->assign("contrato",  "no existe la plantilla" );
		}

	}


	public function setPresupuestoOid($oid){
		if( !empty($oid) ){
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get($oid);
			$this->setPresupuesto($presupuesto);
		}
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}

	public function getPDFRenderer(){

		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
