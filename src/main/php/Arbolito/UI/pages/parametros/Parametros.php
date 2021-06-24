<?php
namespace Arbolito\UI\pages\parametros;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\UI\components\filter\model\UIParametroCriteria;

use Arbolito\UI\components\grid\model\ParametroGridModel;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los parametros.
 *
 * @author Marcos
 * @since 16-07-2018
 *
 */
class Parametros extends ArbolitoPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "parametro.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();




		return array($menuGroup);
	}

	public function getType(){

		return "Parametros";

	}

	public function getModelClazz(){
		return get_class( new ParametroGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIParametroCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("parametro.agregar") );
	}


}
?>
