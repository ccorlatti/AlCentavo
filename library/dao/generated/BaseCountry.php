<?php

/**
 * BaseCountry
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $id
 * @property string $description
 * @property integer $import
 * @property Doctrine_Collection $Account
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseCountry extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('countries');
        $this->hasColumn('country_id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('iso2', 'string', 6, array('type' => 'string', 'length' => 6, 'null' => true));
        $this->hasColumn('short_name', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('long_name', 'string', 60, array('type' => 'string', 'length' => 60, 'notnull' => true));
        $this->hasColumn('main', 'integer', 1, array('type' => 'integer', 'length' => 1, 'default' => '0', 'notnull' => true));
    }

    public function setUp()
    {
    	    	
    }
}
?>