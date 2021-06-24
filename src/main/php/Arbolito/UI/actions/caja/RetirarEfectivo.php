<?php
namespace Arbolito\UI\actions\caja;

use Arbolito\UI\conf\ArbolitoUISetup;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Arbolito\Core\utils\ArbolitoUtils;


use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\Transferencia;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;
use Rasty\Forms\input\InputNumber;


/**
 * se retira efectivo de caja
 *
 * Es una transferencia entre la caja y la caja chica
 *
 * @author Bernardo
 * @since 03/06/2014
 */
class RetirarEfectivo extends Action{


	public function execute(){

		$forward = new Forward();

		//tomamos el monto a retirar
		$number = new InputNumber();
		$monto = $number->formatValue( RastyUtils::getParamPOST("monto") );

		$observaciones = RastyUtils::getParamPOST("observaciones");

		try {

			UIServiceFactory::getUICajaService()->retirarEfectivo($monto, $observaciones);
			$forward->setPageName( "CajaHome" );


		} catch (RastyException $e) {

			$forward->setPageName( "RetirarEfectivo" );
			$forward->addParam( "monto", $monto );
			$forward->addParam( "observaciones", $observaciones );

			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
