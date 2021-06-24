<?php
namespace Arbolito\UI\components\grid\formats;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Rasty\Grid\entitygrid\model\GridValueFormat;

use Arbolito\Core\model\Sucursal;
use Arbolito\Core\model\Producto;
use Rasty\i18n\Locale;

/**
 * Formato para imprte
 *
 * @author Marcos
 * @since 12-03-2018
 *
 */

class GridImporteFormat extends  GridValueFormat{

	private $simbolo;

	public function __construct($simbolo=null){
		$this->simbolo = $simbolo;
	}

	public function format( $value, $item=null ){

		if( $value !=null )
			return  ArbolitoUIUtils::formatMontoToView($value, $this->getSimbolo());
		else $value;
	}



	public function getSimbolo()
	{
	    return $this->simbolo;
	}

	public function setSimbolo($simbolo)
	{
	    $this->simbolo = $simbolo;
	}
}
