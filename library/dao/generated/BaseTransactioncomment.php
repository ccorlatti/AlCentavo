<?php

/**
 * BaseTransactioncomment
 * 
 * This class is member of the DAO layer.
 *  
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseTransactioncomment extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('transactioncomment');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idTransaction', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('content', 'string', 500, array('type' => 'string'));
    }

    public function setUp()
    {
    	
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));

        $this->hasOne('Transaction', array('local' => 'idTransaction',
                                           'foreign' => 'id'));

    }
}
?>