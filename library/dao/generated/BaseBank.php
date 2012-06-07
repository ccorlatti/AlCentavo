<?php

/**
 * BaseBank
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $import
 * @property Doctrine_Collection $Account
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseBank extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('bank');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('code', 'string', 6, array('type' => 'string', 'length' => 6, 'null' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('import', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '0', 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasMany('Account', array('local' => 'id',
                                        'foreign' => 'idBank'));
    }
}
?>