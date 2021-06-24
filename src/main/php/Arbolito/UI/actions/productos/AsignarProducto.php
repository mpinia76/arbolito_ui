<?php
namespace Arbolito\UI\actions\productos;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\Producto;
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
 * se asignar un producto a todos los clientes
 *
 * @author Marcos
 * @since 11/06/2021
 */
class AsignarProducto extends JsonAction{


	public function execute(){

		try {

			$productoOid = RastyUtils::getParamGET("productoOid");

			//obtenemos la producto
			$producto = UIServiceFactory::getUIProductoService()->get($productoOid);

            $user = RastySecurityContext::getUser();
            $user = ArbolitoUtils::getUserByUsername($user->getUsername());

			UIServiceFactory::getUIProductoService()->asignar($producto,$user);

			$result["info"] = Locale::localize("producto.borrar.success")  ;

		} catch (RastyException $e) {

			$result["error"] = Locale::localize($e->getMessage())  ;

		}

		return $result;

	}
}
?>
