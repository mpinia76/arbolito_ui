<?php

namespace Arbolito\UI\components\stats\balance;

use Arbolito\UI\service\UIVentaService;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Arbolito\Core\model\Caja;

use Rasty\utils\LinkBuilder;

use Arbolito\Core\utils\ArbolitoUtils;

use Arbolito\UI\components\filter\model\UIVentaCriteria;
use Arbolito\UI\components\filter\model\UIGastoCriteria;

use Rasty\factory\ComponentConfig;

use Rasty\factory\ComponentFactory;

use Rasty\utils\Logger;

/**
 * Balance de una fecha.
 *
 * @author Bernardo
 * @since 11-12-2014
 */
class BalanceDia extends RastyComponent{

    private $fecha;

    private $filter;

    private $filterType;


    public function getType(){

        return "BalanceDia";

    }

    public function __construct(){


    }

    protected function parseLabels(XTemplate $xtpl){

        $xtpl->assign("lbl_fecha",  $this->localize( "balanceDia.fecha" ) );
        $xtpl->assign("lbl_ventas",  $this->localize( "balanceDia.ventas" ) );
        $xtpl->assign("lbl_pagos",  $this->localize( "balanceDia.pagos" ) );
        $xtpl->assign("lbl_ganancias",  $this->localize( "balanceDia.ganancias" ) );
        $xtpl->assign("lbl_gastos",  $this->localize( "balanceDia.gastos" ) );
        $xtpl->assign("legend_detalle_ventas",  $this->localize( "balanceDia.detalle_ventas.legend" ) );


    }

    protected function parseXTemplate(XTemplate $xtpl){


        $componentConfig = new ComponentConfig();
        $componentConfig->setId( "filter" );
        $componentConfig->setType( $this->getFilterType() );

        $this->filter = ComponentFactory::buildByType($componentConfig, $this);



        $this->filter->fill( );

        $criteria = $this->filter->getCriteria();




        /*labels*/
        $this->parseLabels($xtpl);

        $xtpl->assign("fecha",  ArbolitoUIUtils::formatDateToView( $criteria->getFecha(), "D d M Y") );


        /*$gastos = UIServiceFactory::getUIGastoService()->getTotalesCuenta( null,$this->getFecha() );
        $xtpl->assign("gastos",  ArbolitoUIUtils::formatMontoToView($gastos) );

        $pagos = UIServiceFactory::getUIVentaService()->getTotalesPagosCtaCte( ArbolitoUtils::getCuentaUnica(),$this->getFecha() );
        $xtpl->assign("pagos",  ArbolitoUIUtils::formatMontoToView($pagos) );

        $ventas = UIServiceFactory::getUIVentaService()->getTotalesCuenta( null,$this->getFecha() );
        $xtpl->assign("ventas",  ArbolitoUIUtils::formatMontoToView($ventas) );*/

        $serviceGasto = UIServiceFactory::getUIGastoService();
        $criteriaGasto = new UIGastoCriteria();
        $criteriaGasto->setFiltroPredefinido(0);
        $criteriaGasto->setFecha( $criteria->getFecha());

        $gastoSaldo = $serviceGasto->getTotales($criteriaGasto);
        $criteria->getFecha()->modify("-1 day");

        $criteriaVenta = new UIVentaCriteria();

        $criteriaVenta->setFecha( $criteria->getFecha());

        $criteriaVenta->setCliente( $criteria->getCliente());

        $saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVenta, $criteria );


        Logger::logObject($saldos);

        $xtpl->assign("ganancias",  ArbolitoUIUtils::formatMontoToView($saldos['ganancias']) );
        $xtpl->assign("ventas",  ArbolitoUIUtils::formatMontoToView($saldos['ventas']) );
        $xtpl->assign("gastos",  ArbolitoUIUtils::formatMontoToView((-1)*$gastoSaldo)  );
        if ($saldos['productos']) {
            $productos='';

            foreach ($saldos['productos']['cant'] as $key => $cantidad) {
                //print_r($producto);
                $productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
            }
            $xtpl->assign("productos",  $productos);
        }
        if ($saldos['clientes']) {
            $clientes='';
            $clienteIdAnt='';
            foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
                $arrayKey = explode('-', $key);
                if ($clienteIdAnt!=$arrayKey[0]) {
                    $clientes .=$saldos['clientes']['cliente'][$arrayKey[0]].'<br>';
                }
                $clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
                $clienteIdAnt=$arrayKey[0];
            }
            $xtpl->assign("clientes",  $clientes);
        }
        $xtpl->parse("main.detalles");




    }





    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    protected function initObserverEventType(){
        //TODO $this->addEventType( "Venta" );
    }



    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function getFilterType()
    {
        return $this->filterType;
    }

    public function setFilterType($filterType)
    {
        $this->filterType = $filterType;
    }
}
?>
