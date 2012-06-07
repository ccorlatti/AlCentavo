<?php

/**
 * BaseHolidays
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $specificDay
 * @property integer $specificMonth
 * @property integer $specificYear
 * @property timestamp $created
 * @property timestamp $updated
 * @property timestamp $deleted
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseHolidays extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('holidays');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('description', 'string', 120, array('type' => 'string', 'length' => 120, 'notnull' => true));
        $this->hasColumn('specificDay', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('specificMonth', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('specificYear', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('deleted', 'timestamp', null, array('type' => 'timestamp'));
    }
    
    public function setUp()
    {
    	
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	
    }
}
?>