<?php

/**
 * BaseGroups
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property Doctrine_Collection $Labelgroup
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseGroups extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('groups');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60));
        
        $this->hasColumn('idEntity', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        
        $this->hasColumn('kind', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');

        $this->hasOne('Entity', array('local' => 'idEntity',
                                    'foreign' => 'id')); 
    	$this->actAs('Sluggable', array('unique' => true, 'fields' => array('description','id'), 'canUpdate' => true));
    	    	    	
        $this->hasMany('Labelgroup', array('local' => 'id',
                                           'foreign' => 'idGroup'));
        
        $this->hasMany('Conceptgroup', array('local' => 'id',
                                           'foreign' => 'idGroup'));        
    }
}
?>