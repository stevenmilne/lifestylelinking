<?php
/**
 * LifestyleLinking
 *
 * Normalization of source averages compared to a community average 
 *
 *
 * @package    LifestyleLinking Open Source Project
 * @copyright  Copyright (c) 2010 James Littlejohn
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @version    $Id$
 */

/**
 * Calculates a normalizaton based on a simple percentage
 *
 * @package    LifestyleLinking Open Source Project
 * @copyright  Copyright (c) 2010 James Littlejohn
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */	

class LLnormalization
{
       //
       protected $avgavgcomm;
       protected $indivavg;
       protected $normalMe;


    public function __construct($avgofavg, $indavgarray)
		{
    // need avg of avg array & array for each defintion per individual source
    $this->avgavgcomm = $avgofavg;
    $this->indivavg = $indavgarray;
    //echo 'in normalization';
    //print_r($this->avgavgcomm);
    //echo 'indv avg';
    //print_r($this->indivavg);
    }


   public function normalizationManager ()
		{
      // need to take each individual definition average
        
        
       // need to add a loop foreach individual identity source 
        
        foreach($this->avgavgcomm as $did=>$avgv)
          {
          
                foreach($this->indivavg as $sid=>$cid)
                {
                  //echo 'def avg'.$this->avgavgcomm[$did];
                  $this->normalizeDistances($sid, $did, $this->avgavgcomm[$did]);
                }
        
          }
          
      
    }


    public function normalizeDistances($sid, $did, $avgDef)
    {
    // need to build arrays to perform calculations on
    // sum is   each identity average / average value for a whole defintion
    //echo $avgDef;
    //echo 'norm number';
    //print_r($this->indivavg[$sid][$did]['3']);
    $indivavg = $this->indivavg[$sid][$did]['3'];
    $diffsum = (($indivavg-$avgDef)/$avgDef)*100;
    $diffpercent = round($diffsum, 2);
    //echo 'percent'.$diffpercent;
    $this->normalMe[$sid][$did] = $diffpercent;
    
    }

  	public function normalizeComplete()
		{
      // loadup exlcluded works if not alreadyloaded
      //print_r($this->normalMe);
      return $this->normalMe;
  
    } 

}  // closes class

?>