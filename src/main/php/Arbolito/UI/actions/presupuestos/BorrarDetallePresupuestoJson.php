<?php
namespace Arbolito\UI\actions\presupuestos;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIProductoService;

use Arbolito\UI\service\UIServiceFactory;

use Arbolito\Core\model\DetallePresupuesto;

use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

/**
 * se borra un detalle de presupuesto para la edición
 * en sesión.
 *
 * @author Marcos
 * @since 29/03/2019
 */
class BorrarDetallePresupuestoJson extends JsonAction{


	public function execute(){

		$rasty= RastyMapHelper::getInstance();

		try {

			//indice del detalle a eliminar.
			$index = RastyUtils::getParamPOST("index");
			if(empty($index))
				$index = 0;
			//eliminamos el detalle dado el índice
			ArbolitoUIUtils::borrarDetallePresupuestoSession($index);

			$detalles = ArbolitoUIUtils::getDetallesPresupuestoSession();
			$result["detalles"] = $detalles;

			$result["importe"] = 0;
			foreach ($detalles as $detallejson) {
				$result["importe"] += $detallejson["subtotal"];
			}



		} catch (RastyException $e) {

			$result["error"] = $e->getMessage();
		}

		return $result;

	}

}
?>
