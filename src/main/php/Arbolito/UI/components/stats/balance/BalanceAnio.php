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

use Rasty\factory\ComponentConfig;

use Rasty\factory\ComponentFactory;

use Arbolito\UI\components\filter\model\UIVentaCriteria;
use Arbolito\UI\components\filter\model\UIGastoCriteria;

/**
 * Balance del anio.
 *
 * @author Marcos
 * @since 07-10-2019
 */
class BalanceAnio extends RastyComponent{

    private $fecha;

    public function getType(){

        return "BalanceAnio";

    }

    public function __construct(){
        $fecha = new \DateTime();
        $this->setFecha($fecha);

    }

    protected function parseLabels(XTemplate $xtpl){

        $xtpl->assign("lbl_anio",  $this->localize( "balanceAnio.anio" ) );
        $xtpl->assign("lbl_mes",  $this->localize( "balanceAnio.mes" ) );
        $xtpl->assign("lbl_ventas",  $this->localize( "balanceAnio.ventas" ) );
        $xtpl->assign("lbl_gastos",  $this->localize( "balanceDia.gastos" ) );
        $xtpl->assign("lbl_ganancia",  $this->localize( "balanceAnio.ganancia" ) );

        $xtpl->assign("detalle_mes_legend",  $this->localize( "balanceAnio.detalle_mes.legend" ) );


    }

    protected function parseXTemplate(XTemplate $xtpl){
        ini_set('max_execution_time', '0');
        $componentConfig = new ComponentConfig();
        $componentConfig->setId( "filter" );
        $componentConfig->setType( $this->getFilterType() );

        $this->filter = ComponentFactory::buildByType($componentConfig, $this);



        $this->filter->fill( );

        $criteria = $this->filter->getCriteria();

        /*labels*/
        $this->parseLabels($xtpl);

        $fecha = $criteria->getFecha();
        if(empty($fecha))
            $fecha = new \DateTime();

        $serviceGasto = UIServiceFactory::getUIGastoService();
        $criteriaGasto = new UIGastoCriteria();
        $criteriaGasto->setFiltroPredefinido(0);
        $criteriaGasto->setYear($fecha);

        $gastoSaldo = $serviceGasto->getTotales($criteriaGasto);


        $criteriaVenta = new UIVentaCriteria();

        $criteriaVenta->setYear( $fecha);
        $criteriaVenta->setCliente( $criteria->getCliente());

        $saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVenta, $criteria );

        //$balance = UIServiceFactory::getUIBalanceService()->getBalanceAnio($fecha);


        $balances = array();

        $anio = $fecha->format("Y");

        $meses = ArbolitoUIUtils::getMeses();

        for ($mes = 1; $mes <=12; $mes++) {
            $balances[$mes] = array( "ventas" => 0,

                "ganancias" => 0,
                "mes_nombre" => $meses[$mes]);
        }


        $xtpl->assign("anio",  $fecha->format("Y"));
        /*$xtpl->assign("totalGastos",  ArbolitoUIUtils::formatMontoToView($balance["gastos"]) );
        $xtpl->assign("totalPagos",  ArbolitoUIUtils::formatMontoToView($balance["pagos"]) );*/
        $xtpl->assign("totalVentas",  ArbolitoUIUtils::formatMontoToView($saldos["ventas"]) );
        //$xtpl->assign("totalComisiones",  ArbolitoUIUtils::formatMontoToView($balance["comisiones"]) );
        $xtpl->assign("totalGanancia",  ArbolitoUIUtils::formatMontoToView($saldos["ganancias"]) );
        $xtpl->assign("totalGastos",  ArbolitoUIUtils::formatMontoToView((-1)*$gastoSaldo)  );
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

        $detalles = $balances;

        for ($mes = 1; $mes <=12; $mes++) {

            $xtpl->assign("mes",  $detalles[$mes]["mes_nombre"] );

            $criteriaVentaMes = new UIVentaCriteria();

            $year = ArbolitoUIUtils::yearOfDate($criteria->getFecha());


            $fecha = new \DateTime($year.'-'.$mes.'-01');

            $criteriaGastoMes = new UIGastoCriteria();
            $criteriaGastoMes->setFiltroPredefinido(0);
            $criteriaGastoMes->setMes($fecha);

            $gastoSaldoMes = $serviceGasto->getTotales($criteriaGastoMes);


            $criteriaVentaMes->setMes( $fecha);
            $criteriaVentaMes->setCliente( $criteria->getCliente());

            $saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVentaMes, $criteria );


            $xtpl->assign("ventas",  ArbolitoUIUtils::formatMontoToView($saldos["ventas"]) );
            /*$xtpl->assign("gastos",  ArbolitoUIUtils::formatMontoToView($detalles[$mes]["gastos"]) );
            $xtpl->assign("pagos",  ArbolitoUIUtils::formatMontoToView($detalles[$mes]["pagos"]) );
            $xtpl->assign("comisiones",  ArbolitoUIUtils::formatMontoToView($detalles[$mes]["comisiones"]) );*/
            $xtpl->assign("ganancia",  ArbolitoUIUtils::formatMontoToView($saldos["ganancias"]) );
            $xtpl->assign("gastos",  ArbolitoUIUtils::formatMontoToView((-1)*$gastoSaldoMes)  );
            if ($saldos['productos']) {
                $productos='';

                foreach ($saldos['productos']['cant'] as $key => $cantidad) {
                    //print_r($producto);
                    $productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
                }
                $xtpl->assign("producto",  $productos);
            }
            if ($saldos['clientes']) {
                $clientes='';
                $clienteIdAnt='';
                foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
                    $arrayKey = explode('-', $key);
                    if ($clienteIdAnt!=$arrayKey[0]) {
                        $clientes .='<strong>'.$saldos['clientes']['cliente'][$arrayKey[0]].'</strong><br>';
                    }
                    $clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
                    $clienteIdAnt=$arrayKey[0];
                }
                $xtpl->assign("cliente",  $clientes);
            }
            $xtpl->parse("main.detalle_mes.mes");

        }

        $xtpl->parse("main.detalle_mes");

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
