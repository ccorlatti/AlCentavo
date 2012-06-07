<?php

/**
 * BaseBudgetconcept
 * 
 * This class is member of the DAO layer.
 * 
 * @property integer $idbudget
 * @property integer $idconcept
 * @property decimal $estimatedAmmount
 * @property decimal $effectiveAmmount
 * @property Budget $Budget
 * @property Concept $Concept
 * 
 * @author     Claudio Corlatti <corlatti@gmail.com>
 *  $Id$
 */
abstract class BaseBudgetconcept extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('budgetconcept');
        $this->hasColumn('idbudget', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('idconcept', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true));
        $this->hasColumn('estimatedAmmount', 'decimal', 9, array('type' => 'decimal', 'length' => 9, 'default' => '0.00', 'notnull' => true, 'scale' => false));
        $this->hasColumn('effectiveAmmount', 'decimal', 9, array('type' => 'decimal', 'length' => 9, 'default' => '0.00', 'notnull' => true, 'scale' => false));
    }

    public function setUp()
    {
    	
    	
        $this->hasOne('Budget', array('local' => 'idbudget',
                                      'foreign' => 'id'));

        $this->hasOne('Concept', array('local' => 'idconcept',
                                       'foreign' => 'id'));
    }
}
?>