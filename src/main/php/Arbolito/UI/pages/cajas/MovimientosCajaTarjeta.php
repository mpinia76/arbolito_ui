<?php
namespace Arbolito\UI\pages\cajas;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\UI\components\filter\model\UIMovimientoCajaCriteria;


use Arbolito\UI\components\grid\model\MovimientoCajaTarjetaGridModel;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los movimientos de tarjetas.
 *
 * @author Marcos
 * @since 07-04-2018
 *
 */
class MovimientosCajaTarjeta extends ArbolitoPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "cajaTarjeta.movimientos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "cliente.agregar") );
//		$menuOption->setPageName("ClienteAgregar");
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
//		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "MovimientosCajaTarjeta";

	}

	public function getModelClazz(){
		return get_class( new MovimientoCajaTarjetaGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMovimientoCajaCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		//$xtpl->assign("agregar_label", $this->localize("cliente.agregar") );
	}

//	public function getCaja(){
//
//		//lo fijamos en la cuenta BAPRO.
//		return UIServiceFactory::getUICajaService()->getCajaBAPRO();
//	}


}
?>
