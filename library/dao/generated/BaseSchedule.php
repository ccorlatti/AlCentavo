<?php

/**
 * BaseSchedule
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $days
 * @property integer $months
 * @property integer $years
 * @property integer $businessDay
 * @property integer $weeks
 * @property date $startDate
 * @property date $endDate
 * @property timestamp $created
 * @property timestamp $updated
 * @property Doctrine_Collection $Concept
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseSchedule extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('schedule');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('description', 'string', 120, array('type' => 'string', 'length' => 120, 'notnull' => true));
        $this->hasColumn('days', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('months', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('years', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('businessDay', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('weeks', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('startDate', 'date', null, array('type' => 'date', 'notnull' => true));
        $this->hasColumn('endDate', 'date', null, array('type' => 'date'));
        
        $this->hasColumn('expiBusinessDay', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('expiDay', 'integer', 4, array('type' => 'integer', 'length' => 4));
        $this->hasColumn('noExpiration', 'integer', 4, array('type' => 'integer', 'length' => 4));
        
        $this->hasColumn('created', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
        $this->hasColumn('updated', 'timestamp', null, array('type' => 'timestamp', 'notnull' => true));
    }

    public function setUp()
    {
    	$this->actAs('Timestampable');
        $this->hasMany('Concept', array('local' => 'id',
                                        'foreign' => 'idSchedule'));
    }
}
?>