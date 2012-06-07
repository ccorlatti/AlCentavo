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
abstract class BaseAccount extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('account');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('idBank', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idEntity', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idCurrency', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idAccountType', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));
        
        $this->hasOne('Entity', array('local' => 'idEntity',
                                    'foreign' => 'id'));        

        $this->hasOne('Bank', array('local' => 'idBank',
                                    'foreign' => 'id'));

        $this->hasMany('Accountuserrole', array('local' => 'id',
                                                'foreign' => 'idAccount'));
        
        $this->hasOne('Accounttype', array('local' => 'idAccountType',
                                                'foreign' => 'id'));
        
        $this->hasMany('Import', array('local' => 'id',
                                       'foreign' => 'idAccount'));
        
        $this->hasMany('AccountOptions', array('local' => 'id',
                                       'foreign' => 'idAccount'));        

        $this->hasMany('Transaction', array('local' => 'id',
                                            'foreign' => 'idAccount'));
        
        $this->hasOne('Currency', array('local' => 'idCurrency',
        	                                'foreign' => 'id'));        
    }
}
?>