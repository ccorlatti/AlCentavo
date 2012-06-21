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
	
}

?>