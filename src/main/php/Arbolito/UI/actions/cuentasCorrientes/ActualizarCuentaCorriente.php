<?php
namespace Arbolito\UI\actions\cuentasCorrientes;

use Arbolito\UI\conf\ArbolitoUISetup;

use Arbolito\UI\utils\ArbolitoUIUtils;
use Arbolito\Core\utils\ArbolitoUtils;

use Arbolito\Core\model\CuentaCorriente;

use Arbolito\UI\service\UIServiceFactory;

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
 * se cobra deuda de una cuenta corriente
 *
 * Es una transferencia entre la cuenta corriente seleccionada y la cuenta destino (caja chica o caja del día)
 *
 * @author Marcos
 * @since 13-02-2020
 */
class ActualizarCuentaCorriente extends Action{


	public function execute(){

		$forward = new Forward();

		//tomamos el monto a depositar
		$number = new InputNumber();
		$monto = $number->formatValue( RastyUtils::getParamPOST("monto") );
		$observaciones = RastyUtils::getParamPOST("observaciones");
		$clienteOid = RastyUtils::getParamPOST("cliente");
		//$destinoOid = RastyUtils::getParamPOST("destino");

		try {

			$cliente = UIServiceFactory::getUIClienteService()->get($clienteOid);
			$destino = UIServiceFactory::getUICuentaService()->get(1);

			UIServiceFactory::getUICuentaCorrienteService()->actualizarDeuda($cliente, $destino, $monto, $observaciones);
			$forward->setPageName( "AdminHome" );


		} catch (RastyException $e) {

			$forward->setPageName( "ActualizarCtaCte" );
			$forward->addParam( "monto", $monto );
			$forward->addParam( "observaciones", $observaciones );


			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
