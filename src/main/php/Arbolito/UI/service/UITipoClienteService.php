<?php
namespace Arbolito\UI\service;

use Arbolito\UI\components\filter\model\UITipoClienteCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Arbolito\Core\model\TipoCliente;

use Arbolito\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 *
 * UI service para tiposCliente.
 *
 * @author Marcos
 * @since 10/06/2021
 */
class UITipoClienteService  implements IEntityGridService{

	private static $instance;

	private function __construct() {}

	public static function getInstance() {

		if( self::$instance == null ) {

			self::$instance = new UITipoClienteService();

		}
		return self::$instance;
	}



	public function getList( UITipoClienteCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getTipoClienteService();

			$tiposCliente = $service->getList( $criteria );

			return $tiposCliente;
		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function get( $oid ){

		try{

			$service = ServiceFactory::getTipoClienteService();

			return $service->get( $oid );

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}


	public function add( TipoCliente $tipoCliente ){

		try{

			$service = ServiceFactory::getTipoClienteService();

			return $service->add( $tipoCliente );

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	public function update( TipoCliente $tipoCliente ){

		try{

			$service = ServiceFactory::getTipoClienteService();

			return $service->update( $tipoCliente );

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	function getEntitiesCount($uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getTipoClienteService();
			$tiposCliente = $service->getCount( $criteria );

			return $tiposCliente;

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	function getEntities($uiCriteria){

		return $this->getList($uiCriteria);
	}


	public function delete(TipoCliente $tipoCliente){

		try {

			$service = ServiceFactory::getTipoClienteService();

			return $service->delete($tipoCliente->getOid());

		} catch (\Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}
}
?>
