<?php

namespace Arbolito\UI\components\filter\tipoCliente;

use Arbolito\UI\components\filter\model\UITipoClienteCriteria;

use Arbolito\UI\components\grid\model\TipoClienteGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar tiposCliente
 *
 * @author Marcos
 * @since 10/06/2021
 */
class TipoClienteFilter extends Filter{

	public function getType(){

		return "TipoClienteFilter";
	}


	public function __construct(){

		parent::__construct();

		$this->setGridModelClazz( get_class( new TipoClienteGridModel() ));

		$this->setUicriteriaClazz( get_class( new UITipoClienteCriteria()) );

		//$this->setSelectRowCallback("seleccionarTipoCliente");

		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");

	}

	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_nombre",  $this->localize("tipoCliente.nombre") );

		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "TipoClienteModificar") );


	}
}
?>
