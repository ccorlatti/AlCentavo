<?php

/**
 * BaseAutoreconcileTag
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
abstract class BaseAutoreconcileTag extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('autoreconciletag');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('idConcept', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('idLabel', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('idLabelGroup', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('kind', 'string', 20, array('type' => 'string', 'length' => 20));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	
        $this->hasOne('Concept', array('local' => 'idConcept',
                                       'foreign' => 'id'));

        $this->hasOne('Label', array('local' => 'idLabel',
                                     'foreign' => 'id'));

        $this->hasOne('Groups', array('local' => 'idLabelGroup',
                                      'foreign' => 'id'));
    }
}
?>