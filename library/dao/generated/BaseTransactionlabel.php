<?php

/**
 * BaseTransactionlabel
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idTransaction
 * @property integer $idLabel
 * @property Transaction $Transaction
 * @property Label $Label
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseTransactionlabel extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('transactionlabel');
        $this->hasColumn('idTransaction', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idLabel', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	//$this->actAs('SoftDelete');
    	    	
        $this->hasOne('Transaction', array('local' => 'idTransaction',
                                           'foreign' => 'id'));

        $this->hasOne('Label', array('local' => 'idLabel',
                                     'foreign' => 'id'));
    }
}
?>