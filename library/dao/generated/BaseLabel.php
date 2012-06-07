<?php

/**
 * BaseLabel
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property Doctrine_Collection $Labelgroup
 * @property Doctrine_Collection $Transactionlabel
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseLabel extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('label');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
    	$this->actAs('Sluggable', array('unique' => true, 'fields' => array('description','id'), 'canUpdate' => true));
    	
        $this->hasMany('Labelgroup', array('local' => 'id',
                                           'foreign' => 'idLabel'));

        $this->hasMany('Transactionlabel', array('local' => 'id',
                                                 'foreign' => 'idLabel'));
    }
}
?>