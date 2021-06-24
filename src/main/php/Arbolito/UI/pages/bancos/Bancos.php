<?php
namespace Arbolito\UI\pages\bancos;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\components\filter\model\UIBancoCriteria;

use Arbolito\UI\components\grid\model\BancoGridModel;

use Arbolito\UI\service\UIBancoService;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Arbolito\Core\model\Banco;
use Arbolito\Core\criteria\BancoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los bancos.
 *
 * @author Marcos
 * @since 06/03/2021
 *
 */
class Bancos extends ArbolitoPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "bancos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.bancos.agregar") );
		$menuOption->setPageName("BancoAgregar");
		$menuOption->setIconClass( "icon-agregar fg-green" );
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "Bancos";

	}

	public function getModelClazz(){
		return get_class( new BancoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIBancoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("banco.agregar") );
	}

}
?>
