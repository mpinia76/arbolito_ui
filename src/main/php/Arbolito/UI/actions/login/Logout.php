<?php
namespace Arbolito\UI\actions\login;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\UI\utils\ArbolitoUtils;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;

/**
 * se realiza el logout del sistema.
 *
 * @author Marcos
 * @since 01/03/2018
 */
class Logout extends Action{

	public function isSecure(){
		return false;
	}

	public function execute(){

		$forward = new Forward();
		try {

			RastySecurityContext::logout();

			$forward->setPageName( "Login" );


		} catch (RastyException $e) {

			$forward->setPageName( "Login" );
			$forward->addError( $e->getMessage() );

		}

		return $forward;

	}

}
?>
