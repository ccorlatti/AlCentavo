<?php

/**
 * BaseImport
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $file
 * @property integer $transactionsCount
 * @property integer $idAccount
 * @property Account $Account
 * @property Doctrine_Collection $Transaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseImport extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('import');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('file', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('transactionsCount', 'integer', 4, array('type' => 'integer', 'length' => 4, 'default' => '0', 'notnull' => true));
        $this->hasColumn('duplicates', 'integer', 4, array('type' => 'integer', 'length' => 4, 'default' => '0', 'notnull' => true));
        $this->hasColumn('idAccount', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('Account', array('local' => 'idAccount',
                                       'foreign' => 'id'));

        $this->hasMany('Transaction', array('local' => 'id',
                                            'foreign' => 'idImport'));
    }
}
?>