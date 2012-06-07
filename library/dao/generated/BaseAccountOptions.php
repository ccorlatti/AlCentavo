<?php

/**
 * BaseAccount
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $idBank
 * @property integer $idUser
 * @property integer $idEntity
 * @property User $User
 * @property Bank $Bank
 * @property Doctrine_Collection $Accountuserrole
 * @property Doctrine_Collection $Import
 * @property Doctrine_Collection $Transaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseAccountOptions extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('accountoptions');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idAccount', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('importFiles', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('globalBalance', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('manualTransactions', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('autoLabel', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	
        $this->hasOne('Account', array('local' => 'idAccount',
                                                'foreign' => 'id'));
          
    }
}
?>