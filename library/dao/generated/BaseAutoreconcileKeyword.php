<?php

/**
 * BaseAutoreconcileKeyword
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property integer $idConcept
 * @property integer $idLabel
 * @property timestamp $created
 * @property timestamp $updated
 * @property integer $idLabelGroup
 * @property Concept $Concept
 * @property Label $Label
 * @property Groups $Groups
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseAutoreconcileKeyword extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('autoreconcilekeyword');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idConcept', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('keyword', 'string', 200, array('type' => 'string', 'length' => 200, 'notnull' => true));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('kind', 'string', 20, array('type' => 'string', 'length' => 20));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	
        $this->hasOne('Concept', array('local' => 'idConcept',
                                       'foreign' => 'id'));

    }
}
?>