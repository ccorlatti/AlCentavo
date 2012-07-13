<?php

/**
 * BaseAccount
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $idBank
 * @property integer $idUser
 * @property integer $idEntity
 * @property User $User
 * @property Bank $Bank
 * @property Doctrine_Collection $Accountuserrole
 * @property Doctrine_Collection $Import
 * @property Doctrine_Collection $Transaction
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseAccounttype extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('accounttype');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('bankRequired', 'integer', 4, array('type' => 'integer', 'length' => 4));
        
    }

    public function setUp()
    {
    	$this->actAs('Timestampable'); 
    	
        $this->hasMany('Account', array('local' => 'id',
                                        'foreign' => 'idAccountType'));
             
    }
}
?>