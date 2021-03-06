<?php
/**
 * LifestyleLinking
 *
 * The matching of wise definitions and content words 
 *
 *
 * @package    LifestyleLinking Open Source Project
 * @copyright  Copyright (c) 2010 James Littlejohn
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @version    $Id$
 */

/**
 * Clean definition and source content are process match
 *
 * Manager hands the follow stages
 *
 * Make words wise, frequency count and removal of confusionQuotent/'joing' words e.g. that and at etc.
 * Matrix  Matching words in a content item to a definitions wiseWords
 * Statistics build aggregate statistics of a whole content source over time
 * Avgerage of Averages calculate for all sources in the universe for each definition
 * Normalization  given a community lifestyle definition average, how far is a particular source from that average
 * Peer Group   Given each sources 'distance from a lifestyle definition, order source top to bottom
 * Results  - given individuals input results window (input context) produce results
 * 
 */

	class LLmatrix {
		
		protected $wordsarray;
		protected $definitionarray;
    protected $wordseg;
    protected $matched;
    protected $scoring;
    protected $matrix;
    protected $idmatrix;
	
		public function __construct($definitionWise, $contentwordsWise)
		{
      $this->definitionarray = $definitionWise;	
      $this->wordsarray = $contentwordsWise;
           
      //  need to set segmentation (need to allow future flexibility on this e.g. sentence structure, NLP
      $this->wordseg = array ( 1, 2, 3, 4, 5, 10, 20, 50 );
  //print_r($this->wordsarray);
    }


    public function matrixManager($sid) 
    {
    // feeds startLLmatrix with input arrays per definition
   
    // what def ids are being scored? (find out and loop around) for now each content post is scored for all definitions, this should be smarter to save un-nessary scoring.
    // should pick up this data from framework object.
    //$defids = array('0'=>'1', '1'=>'2');
    //print_r($this->wordsarray);
    //$conids = $contidarray;
    
                  foreach ($this->definitionarray as $did=>$wdef)
                  {
                  //$sid = 1;
                  //print_r($this->wordsarray);
                        foreach($this->wordsarray as $cid=>$ws)
                        {
                        //print_r($cid);
                          // foreach($cid as $ccid=>$words)
                            //{
                                //echo 'defid='.$did.'and sid'.$sid.'andcid='.$cid;
                                $this->startLLmatrix($did, $sid, $cid);
                            //}
                        
                        }
                    
                  }
    
    }


    public function startLLmatrix($did, $sid, $cid) 
    {
    //echo $cid;
      //print_r($this->definitionarray);
      //print_r($this->definitionarray[$did]);
      //print_r($this->wordsarray);
      //print_r($this->wordsarray[$sid][$cid]);
      // if word and definition data not in arrays, then need to make them (either input nosql or query database}.
      if ( (isset($this->definitionarray[$did]) == 1)  &&  (isset($this->wordsarray[$cid][1]) == 1)  )
      {
  
      // this required if more than one definition in core
   //   foreach ($this->definitionarray as $lifeindexid=>$lifewordsarray)
     // {
//print_r($lifewordsarray);
                 foreach ($this->wordseg as $seg)
                 {
//echo $seg;
                  unset($aa3);
                  unset($lifewordsarrays);
                  unset($insertscore);

                  $lifewordsarrays = array_slice($this->definitionarray[$did][1], 0, $seg);
                  //print_r($lifewordsarrays);

                  //echo "<br />newwww<br />";
                  //print_r($this->wordsarray[1]);
                  $aa3 = array_intersect_key( $lifewordsarrays, $this->wordsarray[$cid][1]);
                  //print_r($aa3);

                              if (count($aa3) > 0 )
                              {
                              //echo '<br /><br />';
                              $wordsmatched = count($aa3);
                              //echo $wordsmatched;
                              //echo 'counting<br /><br />';
                              $postscore = array_sum($aa3);
                              //echo $postscore;
                               
                              $this->matrix[$sid][$cid][$did]['matched'][$seg] = $wordsmatched;
                              $this->matrix[$sid][$cid][$did]['scoring'][$seg] = $postscore;

                              }

                              else
                              {

                              $this->matrix[$sid][$cid][$did]['matched'][$seg] = 0;
                              $this->matrix[$sid][$cid][$did]['scoring'][$seg] = 0;
                              }

                }  // closes slice foreachloop
       // }  // first loop 
       } // closes if
      
      }  //  closes function

  
  	public function matrixComplete()
		{
      // loadup exlcluded works if not alreadyloaded
      //echo 'matrix match';
      //print_r($this->matrix);
      // need to add source identity from frawework object/core manager
      return $this->matrix;
  
    } 



} // closes class

?>