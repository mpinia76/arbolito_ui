<?php
namespace Arbolito\UI\components\grid\formats;



use Rasty\i18n\Locale;
use Rasty\Grid\entitygrid\model\GridValueFormat;
/**
 * Formato para mostrar el detalle de una venta
 *
 * @author Marcos
 * @since 28-06-2021
 *
 */

class GridVentaDetallesFormat extends  GridValueFormat{



	public function __construct(){


	}

	public function format( $value, $item=null ){

	    $detalles ='';
		if( $item !=null ){
            foreach ($item->getDetalles() as $detalle) {
                $detalles .=$detalle->getProducto().' ';
            }
        }
		return  $detalles;

	}



}
