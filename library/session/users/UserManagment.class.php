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
			$validationCode = sha1($username . $mail);
			
			$user = new User();
			$user['email'] = $mail;
			$user['password'] = sha1($password);
			$user['username'] = $username;
			$user['name'] = $name;
			$user['validationCode'] = sha1($username . $mail);
			$user->save();
			
			//user disabled to avoid login on inactive accounts
			$user->delete();
			
			$this->emailConfirmation($user['id'], $name, $validationCode, $mail);
			
			
			
			
			$result = $user['id'];
			
		} catch (Exception  $e) {
			throw $e;
		}
		return $result;
	}
	
	
	private function emailConfirmation($id, $name, $validationCode, $mail){
		try {
				
			$tpl = new CCTemplate('../../static/');
			$tpl->cInit('emailBienvenida.html');
			$tpl->cSet('NAME',$name);
			
			$url = SITE_URL . 'activate.php?id='. $id . '&key=' . $validationCode;
			$subject = 'Bienvenido a Al-Centavo! - Activa tu cuenta';
			
			$tpl->cSet('URL', $url);
			
			Util::sendmail($mail, $subject, $tpl->cGetString());
			
		} catch (Exception  $e) {
			throw $e;
		}		
	}
	
	
	
	public function activate($id, $validationCode){
		try {
			$dao = Doctrine::getTable('User');
			$q = $dao->createQuery()
					->update(' User u ')
					->set('active', '\'' . date('Y-m-d H:i:s') . '\'')
					->set('deleted', 'null')
					->where(' 1=1 ')
					->addWhere(' u.validationCode = \'' . $validationCode . '\'')
					->addWhere(' u.id = ' . $id)
					->addWhere(' u.active is null ');
			$affected = $q->execute();
			
			if($affected < 1){
				throw new Exception('El usuario ya esta activo o la clave es incorrecta.');
			}
						
				
		} catch (Exception  $e) {
			throw $e;
		}
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
				->addWhere(' u.active is not null ')
				->setHydrationMode(Doctrine::HYDRATE_ARRAY);
			$rs = $q->fetchArray();			
			
			if(count($rs) < 1){
				throw new Exception('Los datos ingresados son incorrectos.');
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