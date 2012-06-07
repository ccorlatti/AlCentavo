<?php

/**
 * BaseTransaction
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property integer $idUser
 * @property integer $idAccount
 * @property decimal $ammount
 * @property timestamp $when
 * @property string $description
 * @property integer $idParent
 * @property integer $idImport
 * @property integer $idCurrency
 * @property User $User
 * @property Account $Account
 * @property Transaction $Transaction
 * @property Import $Import
 * @property Currency $Currency
 * @property Doctrine_Collection $Receipt
 * @property Doctrine_Collection $Transaction_3
 * @property Doctrine_Collection $Transactionlabel
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseTransaction extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('transaction');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idAccount', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('ammount', 'decimal', 9, array('type' => 'decimal', 'length' => 9, 'notnull' => false, 'scale' => false));
        $this->hasColumn('moment', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('description', 'string', 120, array('type' => 'string', 'length' => 120));
        $this->hasColumn('reference', 'string', 120, array('type' => 'string', 'length' => 120));
        $this->hasColumn('idParent', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('idImport', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('idCurrency', 'integer', 4, array('type' => 'integer', 'length' => 4, 'default' => '1', 'notnull' => true));
        $this->hasColumn('extra', 'string', null, array('type' => 'string'));
    }

    public function setUp()
    {
    	
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
    	$this->actAs('Searchable', 
    		array(
    			'fields' => array('description')
    		)
    	);
    	
    	$this->actAs('Sluggable', array('unique' => false, 'fields' => array('moment', 'description','reference', 'ammount','idCurrency'), 'canUpdate' => false));
    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));

        $this->hasOne('Account', array('local' => 'idAccount',
                                       'foreign' => 'id'));
        
        $this->hasMany('Transactioncomment', array('local' => 'id',
                                           'foreign' => 'idTransaction'));
        
        $this->hasOne('Transaction', array('local' => 'idParent',
                                           'foreign' => 'id'));

        $this->hasOne('Import', array('local' => 'idImport',
                                      'foreign' => 'id'));

        $this->hasOne('Currency', array('local' => 'idCurrency',
                                        'foreign' => 'id'));

        $this->hasMany('Receipt', array('local' => 'id',
                                        'foreign' => 'idTransaction'));

        $this->hasMany('Transaction as Transaction_3', array('local' => 'id',
                                                             'foreign' => 'idParent'));
        
		$this->hasMany('Transaction as Duplicated', array('local' => 'slug',
                                                             'foreign' => 'slug'));        

        $this->hasMany('Transactionlabel', array('local' => 'id',
                                                 'foreign' => 'idTransaction'));
    }
}
?>