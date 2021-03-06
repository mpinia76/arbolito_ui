<?php
namespace Arbolito\UI\actions\caja;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Arbolito\Core\utils\ArbolitoUtils;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\Core\model\Caja;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;
use Rasty\exception\RastyDuplicatedException;
use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

/**
 * se selecciona una caja
 *
 * @author Bernardo
 * @since 12-06-2014
 */
class SeleccionarCaja extends Action{


	public function execute(){

		$forward = new Forward();

		try {

			//obtenemos la caja a seleccionar.
			$cajaOid = RastyUtils::getParamPOST("caja");

			if(!empty($cajaOid)){
				$caja = UIServiceFactory::getUICajaService()->get( $cajaOid );

				ArbolitoUIUtils::setCaja( $caja );
			}else{

				ArbolitoUIUtils::setCaja( null );
			}



			$forward->setPageName( "CajaHome" );

		} catch (RastyDuplicatedException $e) {

			$forward->setPageName( "SeleccionarCaja" );
			$forward->addError( $e->getMessage() );

		} catch (RastyException $e) {

			$forward->setPageName( "SeleccionarCaja" );
			$forward->addError(Locale::localize($e->getMessage()) );

		}

		return $forward;

	}

}
?>
