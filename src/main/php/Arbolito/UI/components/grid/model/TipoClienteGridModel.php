<?php
namespace Arbolito\UI\components\grid\model;

use Arbolito\UI\components\grid\formats\GridImporteFormat;
use Arbolito\UI\components\grid\formats\GridBooleanFormat;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\components\filter\model\UITipoClienteCriteria;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;

use Arbolito\Core\utils\ArbolitoUtils;

use Arbolito\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;
use Rasty\security\RastySecurityContext;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de tiposCliente.
 *
 * @author Marcos
 * @since 10/06/2021
 */
class TipoClienteGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUITipoClienteService();
    }

    public function getFilter(){

    	$filter = new UITipoClienteCriteria();
		return $filter;
    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "tipoCliente.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "nombre", "tipoCliente.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "pagaCuota", "tipoCliente.pagaCuota", 30, EntityGrid::TEXT_ALIGN_LEFT, new GridBooleanFormat()  ) ;
        $this->addColumn( $column );




	}

	public function getDefaultFilterField() {
        return "nombre";
    }

	public function getDefaultOrderField(){
		return "nombre";
	}


    /**
	 * opciones de menú dado el item
	 * @param unknown_type $item
	 */
	public function getMenuGroups( $item ){

		$group = new MenuGroup();
		$group->setLabel("grupo");
		$options = array();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.tiposCliente.modificar") );
		$menuOption->setPageName( "TipoClienteModificar" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;






		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.tipoCliente.eliminar") );
		$menuOption->setActionName( "EliminarTipoCliente" );
		$menuOption->setConfirmMessage( $this->localize( "tipoCliente.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "tipoCliente.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("tipoClienteOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;

		$group->setMenuOptions( $options );

		return array( $group );

	}

}
?>
