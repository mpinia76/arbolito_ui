<?php

namespace Arbolito\UI\components\filter\movimiento;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\components\grid\model\MovimientoCajaGridModel;

use Arbolito\UI\components\filter\model\UIMovimientoCajaCriteria;

use Arbolito\UI\components\filter\model\UIMovimientoCriteria;

use Arbolito\UI\components\grid\model\MovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Caja
 *
 * @author Marcos
 * @since 14-03-2018
 */
class MovimientoCajaFilter extends MovimientoFilter{


	public function getType(){

		return "MovimientoCajaFilter";
	}


	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("cuenta", ArbolitoUIUtils::getCaja() );

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_saldo",  $this->localize( "cuenta.saldo" ) );


	}

}
?>
