<?php

/**
 * BaseBudget
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property integer $month
 * @property integer $year
 * @property timestamp $created
 * @property timestamp $updated
 * @property timestamp $deleted
 * @property integer $idEntity
 * @property Doctrine_Collection $Budgetconcept
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseBudget extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('budget');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('month', 'integer', 2, array('type' => 'integer', 'length' => 2, 'notnull' => true));
        $this->hasColumn('year', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('period', 'date', 4, array('type' => 'date', 'notnull' => true));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('deleted', 'timestamp', null, array('type' => 'timestamp'));
        $this->hasColumn('idEntity', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	
        $this->hasMany('Budgetconcept', array('local' => 'id',
                                              'foreign' => 'idbudget'));
    
		$this->hasOne('Entity', array('local' => 'idEntity',
                                    'foreign' => 'id'));    
    }
}
?>