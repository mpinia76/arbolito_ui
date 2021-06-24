<?php

namespace Arbolito\UI\components\filter\cliente;

use Arbolito\UI\components\filter\model\UIClienteCriteria;

use Arbolito\UI\components\grid\model\ClienteGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar clientes
 *
 * @author Marcos
 * @since 02/03/2018
 */
class ClienteFilter extends Filter{

	public function getType(){

		return "ClienteFilter";
	}


	public function __construct(){

		parent::__construct();

		$this->setGridModelClazz( get_class( new ClienteGridModel() ));

		$this->setUicriteriaClazz( get_class( new UIClienteCriteria()) );

		//$this->setSelectRowCallback("seleccionarCliente");

		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		$this->addProperty("documento");
        $this->addProperty("tipoCliente");
        $this->addProperty("nroSocio");
		//print_r(RastyUtils::getParamGET("tieneCtaCte"));

	}

	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("documento", $this->getInitialText() );*/

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_nombre",  $this->localize("cliente.nombre") );
		$xtpl->assign("lbl_documento",  $this->localize("cliente.documento") );
        $xtpl->assign("lbl_nroSocio",  $this->localize("cliente.nroSocio") );
        $xtpl->assign("lbl_tipoCliente",  $this->localize("cliente.tipoCliente") );




	}



}
?>
