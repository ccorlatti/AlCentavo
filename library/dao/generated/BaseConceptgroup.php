<?php

/**
 * BaseConceptgroup
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idconcept
 * @property integer $idgroup
 * @property timestamp $created
 * @property timestamp $updated
 * @property Concept $Concept
 * @property Groups $Groups
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseConceptgroup extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('conceptgroup');
        $this->hasColumn('idconcept', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idgroup', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	
        $this->hasOne('Concept', array('local' => 'idconcept',
                                       'foreign' => 'id'));

        $this->hasOne('Groups', array('local' => 'idgroup',
                                      'foreign' => 'id'));
    }
}
?>