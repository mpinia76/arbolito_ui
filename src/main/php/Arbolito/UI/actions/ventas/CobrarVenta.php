<?php
namespace Arbolito\UI\actions\ventas;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Arbolito\Core\utils\ArbolitoUtils;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\Venta;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se cobra una venta con una cuenta
 *
 * @author Marcos
 * @since 13/06/2021
 */
class CobrarVenta extends Action{


	public function execute(){

		$forward = new Forward();


		//tomamos la venta
		$ventaOid = RastyUtils::getParamGET("ventaOid");
        $cuentaOid = RastyUtils::getParamGET("cuentaOid");
		$forward->addParam( "ventaOid", $ventaOid );
		try {


			//la recuperamos la venta.
			$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
			//$monto = RastyUtils::getParamGET("monto");
			$monto = $value = str_replace(',', '.', RastyUtils::getParamGET("monto"));
			$montoActualizado = $value = str_replace(',', '.', RastyUtils::getParamGET("montoActualizado"));
			//$venta->setMonto($monto);

			//$cuenta = ArbolitoUtils::getCuentaUnica();
            $cuenta = UIServiceFactory::getUICuentaService()->get( $cuentaOid );


			$user = RastySecurityContext::getUser();
			$user = ArbolitoUtils::getUserByUsername($user->getUsername());

			UIServiceFactory::getUIVentaService()->cobrar($venta, $cuenta, $user, $monto, $montoActualizado);

			$forward->setPageName( "Ventas" );


		} catch (RastyException $e) {

			$forward->setPageName( "VentaCobrar" );
			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
