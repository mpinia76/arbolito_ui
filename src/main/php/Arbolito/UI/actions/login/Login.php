<?php
namespace Arbolito\UI\actions\login;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\Core\utils\ArbolitoUtils;


use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;



/**
 * se realiza el login contra el core.
 *
 * @author Marcos
 * @since 01/03/2018
 */
class Login extends Action{

	public function isSecure(){
		return false;
	}

	public function execute(){

		$forward = new Forward();
		try {


			RastySecurityContext::login( RastyUtils::getParamPOST("username"), RastyUtils::getParamPOST("password") );

			//ArbolitoUIUtils::setSucursal( ArbolitoUtils::getSucursalDefault() );

			$user = RastySecurityContext::getUser();

			$user = ArbolitoUtils::getUserByUsername($user->getUsername());

			if( ArbolitoUtils::isAdmin($user)){

				//$empleado = ArbolitoUtils::getEmpleadoDefault();
				ArbolitoUIUtils::loginAdmin($user);

			}else{

				//TODO
			}

			/*ArbolitoUIUtils::login( $empleado );
			//buscamos la caja que esté abierta para el empleado
			$caja = UIServiceFactory::getUICajaService()->getCajaAbiertaByEmpleado($empleado);
			ArbolitoUIUtils::setCaja($caja);*/

			if( ArbolitoUIUtils::isAdminLogged() )
				$forward->setPageName( $this->getForwardAdmin() );
			/*elseif( ArbolitoUIUtils::isCajaSelected() )
				$forward->setPageName( $this->getForwardEmpleado() );*/
			else //si no hay caja abierta, lo enviamos a abrir una nueva.
				$forward->setPageName( $this->getForwardAdmin() );

		} catch (RastyException $e) {

			$forward->setPageName( $this->getErrorForward() );
			$forward->addError( $e->getMessage() );

		}

		return $forward;

	}

	protected function getForwardEmpleado(){
		return "CajaHome";
	}

	protected function getForwardAdmin(){
		return "AdminHome";
	}

	protected function getForwardCaja(){
		//si hay cajas abiertas lo enviamos a seleccionar una de ellas.

		if( ArbolitoUIUtils::isAdminLogged() )

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas();

		else

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas( new \DateTime() );


		if(count($cajas) > 0)
			return "SeleccionarCaja";
		else
			return "AbrirCaja";
	}

	protected function getErrorForward(){
		return "Login";
	}
}
?>
