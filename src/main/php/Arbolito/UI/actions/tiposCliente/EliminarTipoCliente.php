<?php
namespace Arbolito\UI\actions\tiposCliente;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\TipoCliente;
use Arbolito\Core\utils\ArbolitoUtils;

use Rasty\actions\JsonAction;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se eliminar un tipo de documento
 *
 * @author Marcos
 * @since 10/06/2021
 */
class EliminarTipoCliente extends JsonAction{


	public function execute(){

		try {

			$tipoClienteOid = RastyUtils::getParamGET("tipoClienteOid");

			//obtenemos la tipoCliente
			$tipoCliente = UIServiceFactory::getUITipoClienteService()->get($tipoClienteOid);

			UIServiceFactory::getUITipoClienteService()->delete($tipoCliente);

			$result["info"] = Locale::localize("tipoCliente.borrar.success")  ;

		} catch (RastyException $e) {

			$result["error"] = Locale::localize($e->getMessage())  ;

		}

		return $result;

	}
}
?>
