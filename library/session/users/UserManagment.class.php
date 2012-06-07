<?php
/** 
 * 
 * @author Claudio Corlatti
 * 
 */
class UserManagment {
	
	function __construct() {
	
	}
	
	public function register($name, $username, $mail, $password){
		$result = null;
		try {
			
			$this->checkExists($username, $mail);
			
			$user = new User();
			$user['email'] = $mail;
			$user['password'] = sha1($password);
			$user['username'] = $username;
			$user['name'] = $name;
			$user['validationCode'] = sha1($username . $mail);
			$user->save();
			
			$user->delete();
			
			$result = $user['id'];
			
		} catch (Exception  $e) {
			throw $e;
		}
		return $result;
	}
	
	
	public function checkExists($username, $mail){
		$result = false;
		try {
			$dao = Doctrine::getTable('User');
			
			$q = $dao->createQuery()
				->from(' User u ')
				->where(' 1=1 ')
				->addWhere(' u.username = ? ', $username)
				->setHydrationMode(Doctrine::HYDRATE_ARRAY);
			$rs = $q->fetchArray();			
			
			if(count($rs) > 0){
				throw new Exception('El usuario ya existe en el sitio, por favor intenta con uno distinto.');
			} else {
				$q = $dao->createQuery()
					->from(' User u ')
					->where(' 1=1 ')
					->addWhere(' u.email = ? ', $mail)
					->setHydrationMode(Doctrine::HYDRATE_ARRAY);
				$rs = $q->fetchArray();					
				if(count($rs) > 0){
					throw new Exception('El e-mail que ingresaste ya esta siendo usado por otro usuario, por favor intenta con uno distinto.');
				} else {
					$result = true;
				}
			}
		} catch(Exception $e){
			throw $e;
		}
		return $result;		
	}	

	public function login($username, $password){
		$result = false;
		try {
			$dao = Doctrine::getTable('User');
			
			$q = $dao->createQuery()
				->from(' User u ')
				->where(' 1=1 ')
				->addWhere(' ( u.username = ? or u.email = ? )', array($username, $username))
				->addWhere(' u.password = ? ', sha1($password))
				->addWhere(' u.deleted is null ')
				->setHydrationMode(Doctrine::HYDRATE_ARRAY);
			$rs = $q->fetchArray();			
			
			if(count($rs) < 1){
				throw new Exception('Los datos que ingresaste no son correctos.');
			} else {
				$result = $rs[0];
			}
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}
			
}

?>