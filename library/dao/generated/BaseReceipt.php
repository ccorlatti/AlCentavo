<?php

/**
 * BaseReceipt
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property integer $idTransaction
 * @property string $path
 * @property Transaction $Transaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseReceipt extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('receipt');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idTransaction', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('path', 'string', 250, array('type' => 'string', 'length' => 250, 'notnull' => true));
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