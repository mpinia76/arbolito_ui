<?php
namespace Arbolito\UI\components\grid\model;

use Arbolito\UI\components\grid\formats\GridImporteFormat;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\components\filter\model\UIVentaCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;
use Rasty\Grid\entitygrid\model\GridDatetimeFormat;
use Arbolito\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de movimientos de cuenta.
 *
 * @author Marcos
 * @since 07/04/2018
 */
class MovimientoVentaGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIMovimientoVentaService();
    }

	public function getFilter(){
//
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "movimientoVentasfilter" );
		$componentConfig->setType( "MovimientoVentaFilter" );
//
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);

    	/*$filter = new UIGastoCriteria();

		return $filter;  */

    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "movimientoCaja.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fecha", "movimientoCaja.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "descripcion", "movimientoCaja.concepto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		/*$column = GridModelBuilder::buildColumn( "observaciones", "movimientoCaja.observaciones", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );*/

		$column = GridModelBuilder::buildColumn( "user.name", "login.username", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "haber", "movimientoCaja.haber", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "debe", "movimientoCaja.debe", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );


	}

	public function getDefaultFilterField() {
        return "oid";
    }

	public function getDefaultOrderField(){
		return "oid";
	}

	public function getDefaultOrderType(){
		return "DESC";
	}

    /**
	 * opciones de men?? dado el item
	 * @param unknown_type $item
	 */
	public function getMenuGroups( $item ){

		$group = new MenuGroup();
		$group->setLabel("grupo");
		$options = array();

		$service = $this->getService();
		$movimiento = $service->get($item->getOid());

		$movimientoClass = get_class( $movimiento );

		//Logger::log($movimientoClass);
		if ($movimientoClass=='Arbolito\Core\model\MovimientoVenta') {
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.ventas.pdf") );
			$menuOption->setPdf(1);
			$menuOption->setTarget("_blank");
			$menuOption->setPageName( "VentaPDF" );
			$menuOption->addParam("ventaOid",$movimiento->getVenta()->getOid());
			$menuOption->setImageSource( $this->getWebPath() . "css/images/pdf_16.png" );
			$options[] = $menuOption ;
		}
		$group->setMenuOptions( $options );

		return array( $group );

	}

	public function getHeaderContent(){
		$filter = $this->getFilter();
		$filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );
		//print_r($filter->getCriteria());
		$service = UIServiceFactory::getUIVentaService();


		//print_r($filter);

		$criteria = new UIVentaCriteria();
		$criteria->setFiltroPredefinido(0);
		$criteria->setFechaDesde($filter->getCriteria()->getFechaDesde());
		$criteria->setFechaHasta($filter->getCriteria()->getFechaHasta());
		$criteria->setUser($filter->getCriteria()->getUser());

		return 'Bruto: <strong>'.ArbolitoUIUtils::formatMontoToView($service->getTotales($criteria)).'</strong> Neto: <strong>'.ArbolitoUIUtils::formatMontoToView($service->getGanancias($criteria)).'</strong>';
	}

}
?>
