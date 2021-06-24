<?php
namespace Arbolito\UI\pages\gastos;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\components\filter\model\UIGastoCriteria;

use Arbolito\UI\components\grid\model\GastoGridModel;

use Arbolito\UI\service\UIGastoService;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Arbolito\Core\model\Gasto;
use Arbolito\Core\criteria\GastoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los gastos.
 *
 * @author Marcos
 * @since 12/03/2018
 *
 */
class Gastos extends ArbolitoPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "gastos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.gastos.agregar") );
		$menuOption->setPageName("GastoAgregar");
		$menuOption->setIconClass( "icon-agregar fg-green" );
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "Gastos";

	}

	public function getModelClazz(){
		return get_class( new GastoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIGastoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("gasto.agregar") );
	}

}
?>
