<?php

/**
 * BaseUser
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $validationCode
 * @property Doctrine_Collection $Account
 * @property Doctrine_Collection $Accountuserrole
 * @property Doctrine_Collection $Entityuser
 * @property Doctrine_Collection $Transaction
 * @property Doctrine_Collection $Userdata
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseUser extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('name', 'string', 40, array('type' => 'string', 'length' => 40));
        $this->hasColumn('username', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('password', 'string', 255, array('type' => 'string', 'length' => 255, 'notnull' => true));
        $this->hasColumn('email', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('validationCode', 'string', 60, array('type' => 'string', 'length' => 60));
        $this->hasColumn('active', 'timestamp', null, array('type' => 'timestamp'));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasMany('Account', array('local' => 'id',
                                        'foreign' => 'idUser'));

        $this->hasMany('Accountuserrole', array('local' => 'id',
                                                'foreign' => 'idUser'));

        $this->hasMany('Entityuser', array('local' => 'id',
                                           'foreign' => 'idUser'));

        $this->hasMany('Transaction', array('local' => 'id',
                                            'foreign' => 'idUser'));

        $this->hasMany('Userdata', array('local' => 'id',
                                         'foreign' => 'idUser'));
    }
}
?>