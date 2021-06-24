<?php
namespace Arbolito\UI\actions\presupuestos;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\Presupuesto;
use Arbolito\Core\utils\ArbolitoUtils;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se anula una presupuesto
 *
 * @author Marcos
 * @since 01/04/2019
 */
class AprobarPresupuesto extends Action{


	public function execute(){

		$forward = new Forward();


		//tomamos la presupuesto
		$presupuestoOid = RastyUtils::getParamPOST("presupuestoOid");
		$forward->addParam( "presupuestoOid", $presupuestoOid );
		try {

			//la recuperamos la presupuesto.
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get( $presupuestoOid );

			$user = RastySecurityContext::getUser();
			$user = ArbolitoUtils::getUserByUsername($user->getUsername());

			UIServiceFactory::getUIPresupuestoService()->aprobar($presupuesto, $user);

			$forward->setPageName( "Ventas" );


		} catch (RastyException $e) {

			$forward->setPageName( "PresupuestoAprobar" );
			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
