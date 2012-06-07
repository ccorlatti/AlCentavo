<?php

/**
 * BaseSubtransaction
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property integer $idTransaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseSubtransaction extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('subtransaction');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idTransaction', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }
    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('Transaction', array('local' => 'idTransaction',
                                           'foreign' => 'id'));

    }
}
?>