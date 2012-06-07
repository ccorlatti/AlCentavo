<?php

/**
 * BaseConcept
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $idSchedule
 * @property integer $autoPlan
 * @property integer $askBeforeReconcile
 * @property timestamp $created
 * @property timestamp $updated
 * @property timestamp $deleted
 * @property integer $idEntity
 * @property decimal $referenceAmmount
 * @property integer $idCurrency
 * @property decimal $margin
 * @property integer $sendAlarm
 * @property string $slug
 * @property Entity $Entity
 * @property Currency $Currency
 * @property Schedule $Schedule
 * @property Doctrine_Collection $Autoreconcile
 * @property Doctrine_Collection $Budgetconcept
 * @property Doctrine_Collection $Conceptgroup
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseConcept extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('concept');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 120, array('type' => 'string', 'length' => 120, 'notnull' => true));
        $this->hasColumn('idSchedule', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('autoPlan', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '1', 'notnull' => true));
        $this->hasColumn('askBeforeReconcile', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '1', 'notnull' => true));
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('deleted', 'timestamp', null, array('type' => 'timestamp'));
        $this->hasColumn('idEntity', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('referenceAmmount', 'decimal', 9, array('type' => 'decimal', 'length' => 9, 'default' => '0.00', 'notnull' => true, 'scale' => false));
        $this->hasColumn('idCurrency', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
        $this->hasColumn('margin', 'decimal', 9, array('type' => 'decimal', 'length' => 9, 'default' => '10.00', 'notnull' => true, 'scale' => false));
        $this->hasColumn('sendAlarm', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '0', 'notnull' => true));
        $this->hasColumn('slug', 'string', 255, array('type' => 'string', 'length' => 255));
        $this->hasColumn('idUser', 'integer', 4, array('type' => 'integer', 'length' => 4, 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Sluggable', array('unique' => true, 'fields' => array('description','id'), 'canUpdate' => true));
    	$this->actAs('Timestampable');
    	$this->actAs('SoftDelete');
    	
        $this->hasOne('Entity', array('local' => 'idEntity',
                                      'foreign' => 'id'));

        $this->hasOne('Currency', array('local' => 'idCurrency',
                                        'foreign' => 'id'));

        $this->hasOne('Schedule', array('local' => 'idSchedule',
                                        'foreign' => 'id'));

        $this->hasMany('AutoreconcileTag', array('local' => 'id',
                                              'foreign' => 'idConcept'));

        $this->hasMany('AutoreconcileKeyword', array('local' => 'id',
        	                                  'foreign' => 'idConcept'));
        
        $this->hasMany('Budgetconcept', array('local' => 'id',
                                              'foreign' => 'idconcept'));

        $this->hasMany('Conceptgroup', array('local' => 'id',
                                             'foreign' => 'idconcept'));

        $this->hasOne('User', array('local' => 'idUser',
                                    'foreign' => 'id'));        
    }
}
?>