<?php

/**
 * BaseEntityuser
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idUser
 * @property integer $idEntity
 * @property string $description
 * @property User $User
 * @property Entity $Entity
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseEntityuser extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('entityuser');
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idEntity', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));

        $this->hasOne('Entity', array('local' => 'idEntity',
                                      'foreign' => 'id'));
    }
}
?>