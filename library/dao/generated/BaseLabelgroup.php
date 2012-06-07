<?php

/**
 * BaseLabelgroup
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idLabel
 * @property integer $idGroup
 * @property Label $Label
 * @property Groups $Groups
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseLabelgroup extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('labelgroup');
        $this->hasColumn('idLabel', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idGroup', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('Label', array('local' => 'idLabel',
                                     'foreign' => 'id'));

        $this->hasOne('Groups', array('local' => 'idGroup',
                                      'foreign' => 'id'));
    }
}
?>