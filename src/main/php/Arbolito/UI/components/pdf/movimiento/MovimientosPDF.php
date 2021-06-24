<?php

namespace Arbolito\UI\components\pdf\movimiento;

use Datetime;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Arbolito\UI\components\filter\model\UIMovimientoCuentaCriteria;



use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;
use Rasty\factory\PageFactory;

use Rasty\utils\Logger;


/**
 * para renderizar en pdf listado de movimientos.
 *
 * @author Marcos
 * @since 04-05-2021
 *
 */
class MovimientosPDF extends RastyComponent{



	public function getType(){

		return "MovimientosPDF";

	}

	public function __construct(){


	}


	protected function parseXTemplate(XTemplate $xtpl){

		$page = PageFactory::build("MovimientosBanco");

		$movimientoCriteria = new UIMovimientoCuentaCriteria();

		$movimientoFilter = $page->getComponentById("movimientosFilter");

		$movimientoFilter->fillFromSaved($movimientoCriteria);
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		$xtpl->assign( "fecha", ArbolitoUIUtils::formatDateTimeToView(new Datetime()) );

        $xtpl->assign( "cuenta", $movimientoCriteria->getCuenta());
        if ($movimientoCriteria->getFechaDesde()&&$movimientoCriteria->getFechaHasta()){
            $xtpl->assign( "entreFechas", 'Entre las fechas '.ArbolitoUIUtils::formatDateToView($movimientoCriteria->getFechaDesde()).' y '.ArbolitoUIUtils::formatDateToView($movimientoCriteria->getFechaHasta()));
        }


		$xtpl->assign("lbl_fecha", $this->localize( "movimientoCuenta.fechaHora" ) );
        $xtpl->assign("lbl_concepto", $this->localize( "movimientoCuenta.concepto" ) );
        $xtpl->assign("lbl_debe", $this->localize( "movimientoCuenta.debe" ) );
        $xtpl->assign("lbl_haber", $this->localize( "movimientoCuenta.haber" ) );
        $xtpl->assign("lbl_saldo", $this->localize( "movimientoCuenta.saldo" ) );




        $movimientos = UIServiceFactory::getUIMovimientoCuentaService()->getList($movimientoCriteria);
        //print_r($movimientos);
        foreach ($movimientos as $movimiento) {
            echo $movimiento->getDebe();
            $xtpl->assign( "fechaHora", ArbolitoUIUtils::formatDateTimeToView($movimiento->getFechaHora()) );
            $xtpl->assign( "concepto", $movimiento->getDescripcion() );

            $xtpl->assign( "debe", ArbolitoUIUtils::formatMontoToView( $movimiento->getDebe() ) );
            $xtpl->assign( "haber", ArbolitoUIUtils::formatMontoToView( $movimiento->getHaber() ) );
            $xtpl->assign( "saldo", ArbolitoUIUtils::formatMontoToView( $movimiento->getSaldo() ) );

            $xtpl->parse( "main.movimientos.detalle" );


        }
        if ($movimientos) {
            $xtpl->parse( "main.movimientos" );
        }









	}







	public function getPDFRenderer(){

		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
