<?php
namespace Arbolito\UI\actions\pedidos;

use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\Pedido;
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
 * se anula la recepción de un pedido
 *
 * @author Marcos
 * @since 10-07-2020
 */
class AnularRecibirPedido extends Action{


	public function execute(){

		$forward = new Forward();


		//tomamos el pedido
		$pedidoOid = RastyUtils::getParamPOST("pedidoOid");
		$forward->addParam( "pedidoOid", $pedidoOid );
		try {

			//recuperamos el pedido.
			$pedido = UIServiceFactory::getUIPedidoService()->get( $pedidoOid );

			$user = RastySecurityContext::getUser();
			$user = ArbolitoUtils::getUserByUsername($user->getUsername());

			UIServiceFactory::getUIPedidoService()->anularRecibir($pedido, $user);

			$forward->setPageName( "Pedidos" );


		} catch (RastyException $e) {

			$forward->setPageName( "PedidoAnularRecibir" );
			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
