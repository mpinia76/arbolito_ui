<?php
namespace Arbolito\UI\pages\caja;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\components\filter\model\UIMovimientoCuentaCriteria;

use Arbolito\UI\components\grid\model\MovimientoCuentaGridModel;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los movimientos de la caja actual.
 *
 * @author Bernardo
 * @since 28/05/2014
 *
 */
class MovimientosCajaActual extends ArbolitoPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "caja.movimientos.title" );
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

		return "MovimientosCajaActual";

	}

	public function getModelClazz(){
		return get_class( new MovimientoCuentaGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMovimientoCuentaCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		//$xtpl->assign("agregar_label", $this->localize("cliente.agregar") );
	}

	public function getCaja(){
		$caja = ArbolitoUIUtils::getCaja();
		$caja = UIServiceFactory::getUICajaService()->get( $caja->getOid() );
		return $caja;
	}
}
?>
