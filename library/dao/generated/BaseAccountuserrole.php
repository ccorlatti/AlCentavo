<?php

/**
 * BaseAccountuserrole
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idUser
 * @property integer $idAccount
 * @property integer $idRole
 * @property User $User
 * @property Account $Account
 * @property Role $Role
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseAccountuserrole extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('accountuserrole');
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idAccount', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idRole', 'integer', 4, array('type' => 'integer', 'length' => 4, 'default' => '1', 'notnull' => true));
    }

    public function setUp()
    {
    	
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));

        $this->hasOne('Account', array('local' => 'idAccount',
                                       'foreign' => 'id'));

        $this->hasOne('Role', array('local' => 'idRole',
                                    'foreign' => 'id'));
    }
}
?>