<?php

/** 
 * $Id$
 * 
 * @author Claudio Corlatti
 * 
 * 
 */
class AccountManagment {
	
	function __construct() {
	
	}
	
	public function getAccountTypes($idAccount) {
		$result = false;
		try {
	
			$dao = Doctrine::getTable('Accounttype');
			$q = $dao->createQuery()
			->from(' Accounttype t ');
			if(!empty($idAccount)){
				$q->leftJoin(' t.Account a with a.id=' . $idAccount);
			}
			$q->where(' 1=1 ')
			
			->orderBy(' t.description ');
			$result = $q->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchArray();
	
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}
	
	
	public function getEnabledBanks($idCountry) {
		$result = false;
		try {
	
			$dao = Doctrine::getTable('Bank');
			$q = $dao->createQuery()
			->from(' Bank b ');
			$q->innerJoin(' b.Country a ');
			$q->where(' 1=1 ');
			if(!empty($idCountry)){
				$q->addWhere('b.country=' . $idCountry);
			}
			$q->addWhere(' b.deleted is null ')
			->orderBy(' a.short_name, b.description ');
			
			
			$result = $q->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchArray();
	
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}	
	
	public function doIHavePermissionForThisAccount($idAccount, $idUser){
		$result = false;
		try {
		
			$dao = Doctrine::getTable('Account');
			$q = $dao->createQuery()
			->from(' Account a ')
			->where(' 1=1 ')
			->addWhere(' a.idUser =' . $idUser)
			->addWhere(' a.id =' . $idAccount);
				
			$rs = $q->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchArray();
			if(count($rs) > 0){
				$result = true;
			}
		
		} catch(Exception $e){
			throw $e;
		}
		return $result;		
	}
	
	public function saveSimpleAccount($idAccount, $idUser, $basicData) {
		$result = false;
		try {
	
			$account = new Account();
			if(!empty($idAccount)){
				$account->assignIdentifier($idAccount);
			}
				
			$account['idUser'] = $idUser;
			$account['description'] = $basicData['description'];
			$account['idBank'] = $basicData['idBank'];
			$account['idCurrency'] = $basicData['idCurrency'];
			$account['idAccountType'] = $basicData['idAccountType'];
				
			//TODO permisos de cuenta
			$account['idEntity'] = 1;
				
			$account->save();
			if(!empty($account['id'])){
				$this->saveInitialBalance($account['id'], $idUser, $basicData['idCurrency'], $basicData['initialBalance']);
			}
			
			$result = $account['id'];
			
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}
	
	public function deleteAccount($idAccount) {
		$result = false;
		try {
	
			$account = new Account();
			$account->assignIdentifier($idAccount);
			$account->delete();
				
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}	
	
	public function getCurrencies($idAccount) {
		$result = false;
		try {
	
			$dao = Doctrine::getTable('Currency');
			$q = $dao->createQuery()
			->from(' Currency b ');
			if(!empty($idAccount)){
				$q->leftJoin(' b.Account a with a.id=' . $idAccount);
			}
			$q->where(' 1=1 ')
			->addWhere(' b.deleted is null ')
			->orderBy(' b.description ');
			$result = $q->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchArray();
	
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}
	
	public function saveInitialBalance($idAccount, $idUser, $idCurrency, $ammount){
		$result = null;
		try {
	
			
			$obj = new Transaction();
			$obj['idUser'] = $idUser;
			$obj['idAccount'] = $idAccount;
			$obj['idCurrency'] = $idCurrency;
			$obj['description'] = 'AJUSTE DE SALDO';
			$obj['moment'] = !empty($oldestTransaction[0]['moment']) ? $oldestTransaction[0]['moment'] : date('Y-m-d');
			$obj['ammount'] = $ammount;
			$obj['reference'] = -1;
			$obj->save();
				
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}	
	
	public function getEnabledAccounts($idUser){
		$result = null;
		try {
			$dao = Doctrine::getTable('Account');
			$q = $dao->createQuery()
			->from(' Account a ')
			->leftJoin(' a.Entity e ')
			->leftJoin(' e.Entityuser us ')
			->innerJoin(' a.Bank b ')
			->innerJoin(' a.Currency c ')
			->innerJoin(' a.Accounttype ac ')
			->where(' 1=1 ')
			->addWhere(' ( us.idUser = ' . $idUser . ' or a.idUser=' . $idUser . ')')
			->addWhere(' a.deleted is null ')
			->addWhere(' e.deleted is null ')
			->addWhere(' us.deleted is null ')
			->addWhere(' b.deleted is null ')
			->orderBy(' a.description ');
	
			$result = $q->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchArray();
		} catch (Exception $e){
			throw $e;
		}
		return $result;
	}	
	
}

?>