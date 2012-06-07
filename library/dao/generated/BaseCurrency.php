<?php

/**
 * BaseCurrency
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $main
 * @property decimal $equivalency
 * @property string $symbol
 * @property Doctrine_Collection $Transaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseCurrency extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('currency');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 20, array('type' => 'string', 'length' => 20, 'notnull' => true));
        $this->hasColumn('main', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '0', 'notnull' => true));
        $this->hasColumn('equivalency', 'decimal', 10, array('type' => 'decimal', 'length' => 10, 'default' => '1', 'notnull' => true));
        $this->hasColumn('symbol', 'string', 6, array('type' => 'string', 'length' => 6, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasMany('Transaction', array('local' => 'id',
                                            'foreign' => 'idCurrency'));
        
        $this->hasMany('Account', array('local' => 'id',
                                            'foreign' => 'idCurrency'));        
    }
}
?>