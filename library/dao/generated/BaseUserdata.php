<?php

/**
 * BaseUserdata
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idUser
 * @property string $avatar
 * @property User $User
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseUserdata extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('userdata');
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('avatar', 'string', 255, array('type' => 'string', 'length' => 255));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	    	
        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));
    }
}
?>