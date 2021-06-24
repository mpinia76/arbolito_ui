<?php
namespace Arbolito\UI\service;

use Arbolito\UI\components\filter\model\UIBancoCriteria;


use Arbolito\UI\utils\ArbolitoUIUtils;
use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Arbolito\Core\service\ServiceFactory;

use Arbolito\Core\utils\ArbolitoUtils;
use Arbolito\Core\model\Banco;
use Arbolito\Core\model\Transferencia;

use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;


/**
 *
 * UI service para Banco.
 *
 * @author Bernardo
 * @since 09-06-2014
 */
class UIBancoService {

	private static $instance;

	private function __construct() {}

	public static function getInstance() {

		if( self::$instance == null ) {

			self::$instance = new UIBancoService();

		}
		return self::$instance;
	}



	public function getList( UIBancoCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getBancoService();

			$bancos = $service->getList( $criteria );

			return $bancos;

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}


	public function get( $oid ){

		try {

			$service = ServiceFactory::getBancoService();

			return $service->get( $oid );

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getCuentaBAPROCtaCte(){

		try {

			return ArbolitoUtils::getCuentaBAPROCtaCte();

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	public function getCuentaBAPROCajaAhorro(){

		try {

			return ArbolitoUtils::getCuentaBAPROCajaAhorro();

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	public function getCuentaARISTEGUI1(){

		try {

			return ArbolitoUtils::getCuentaARISTEGUI1();

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	public function getCuentaARISTEGUI2(){

		try {

			return ArbolitoUtils::getCuentaARISTEGUI2();

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}


	public function depositarEfectivo(Banco $banco, $monto, $observaciones, $fechaHora ){

		try{

			//recuperamos la caja chica.
			//$cajaChica = UIServiceFactory::getUICuentaService()->getCajaChica();

			$user = RastySecurityContext::getUser();
			$user = ArbolitoUtils::getUserByUsername($user->getUsername());

			$transferencia = new Transferencia();
			//$transferencia->setOrigen( $cajaChica );
			$transferencia->setDestino( $banco );
			$transferencia->setMonto( $monto );
			$transferencia->setFechaHora( $fechaHora );
			$transferencia->setObservaciones( $observaciones );
			$transferencia->setUser( $user );
           // $transferencia->setSite(ArbolitoUIUtils::getAdminSiteLogged());
			UIServiceFactory::getUITransferenciaService()->add( $transferencia );

		} catch (\Exception $e) {

			throw new RastyException($e->getMessage());

		}

	}

	/**
	 * retorna los saldos de todos los bancos
	 */
	public function getSaldoBancos(UIBancoCriteria $criteria){

		$bancos = $this->getList($criteria);
		$saldos = 0;
		foreach ($bancos as $banco) {
			$saldos += $banco->getSaldo();
		}
		return $saldos;
	}

	/**
	 * retorna los saldos de todos los bancos
	 */
	public function getSaldoBanco(UIBancoCriteria $criteria){

		$bancos = $this->getList($criteria);
		$saldos = 0;
		foreach ($bancos as $banco) {
			$saldos += $banco->getSaldo();
		}
		return $saldos;
	}

    function getEntitiesCount($uiCriteria){

        try{

            $criteria = $uiCriteria->buildCoreCriteria() ;

            $service = ServiceFactory::getCuentaService();
            $cuentas = $service->getCount( $criteria );

            return $cuentas;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    function getEntities($uiCriteria){

        return $this->getList($uiCriteria);
    }

    public function add( Banco $banco ){

        try {

            $service = ServiceFactory::getBancoService();

            return $service->add( $banco );

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function update( Banco $banco ){

        try{

            $service = ServiceFactory::getBancoService();

            return $service->update( $banco );

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }

    }




    public function delete(Banco $banco){

        try {

            $service = ServiceFactory::getBancoService();

            return $service->delete($banco->getOid());

        } catch (\Exception $e) {

            throw new RastyException( $e->getMessage() );

        }

    }

}
?>
