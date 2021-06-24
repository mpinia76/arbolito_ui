<?php

namespace Arbolito\UI\components\filter\movimiento;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\components\grid\model\MovimientoCuentaGridModel;

use Arbolito\UI\components\filter\model\UIMovimientoCuentaCriteria;

use Arbolito\UI\components\filter\model\UIMovimientoCriteria;

use Arbolito\UI\components\grid\model\MovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Cuenta
 *
 * @author Bernardo
 * @since 05-06-2014
 */
class MovimientoCuentaFilter extends MovimientoFilter{


	public function getType(){

		return "MovimientoCuentaFilter";
	}


	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("cuenta", ArbolitoUIUtils::getCaja() );

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_saldo",  $this->localize( "cuenta.saldo" ) );


	}

}
?>
