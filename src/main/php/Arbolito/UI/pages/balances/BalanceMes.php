<?php
namespace Arbolito\UI\pages\balances;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\components\filter\model\UIProductoCriteria;



use Arbolito\UI\service\UIVentaService;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Arbolito\Core\model\Caja;
use Arbolito\Core\criteria\VentaCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar las balances.
 *
 * @author Marcos
 * @since 08/10/2019
 *
 */
class BalanceMes extends ArbolitoPage{



	public function __construct(){

	}

	public function getTitle(){
		return $this->localize("balanceMes.title") ;
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();




		return array($menuGroup);
	}

	public function getType(){

		return "BalanceMes";

	}


	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}



}
?>
