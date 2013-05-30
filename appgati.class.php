<?php

/**
 * @file
 *  A class to help in gauging page load time of your PHP applications.
 *  It does nothing different than using built-in PHP functions other than
 *  providing cleaner implementation and handling some small
 *  calculations for you :)
 *  It does not work on Windows!
 */

/**
 * Class code.
 */
class AppGati {

  /**
   * Constructor.
   */
  public function AppGati() {
    //parent::__construct();
  }

  /**
   * Return time.
   */
  public function Time() {
  	return microtime(true);
  }

  /**
   * Return usage.
   * @param
   *  $format: array or string.
   * @return
   *  Result of calling getrusage() in form of an array or a string.
   */
  public function Usage($format = 'array') {
  	// Return array by default.
  	if (!$format || $format == 'array') {
  	  return getrusage();
  	}
  	// Return string  if specified.
  	else if ($format == 'string') {
  	  return str_replace('&', ', ', http_build_query(getrusage()));
  	}
  }

  /**
   * Set time by label.
   */
  protected function SetTime($label = NULL) {
    $label = $label ? $label . '_time' : 'SetTime';
    $this->$label = $this->Time();
  }
  
  /**
   * Set usage by label..
   */
  protected function SetUsage($label = NULL, $format = NULL) {
    $label = $label ? $label . '_usage' : 'SetUsage';
    $this->$label = $this->Usage($format);
  }

  /**
   * Set a step for benchmarking.
   */
  public function Step($label = NULL, $format = NULL) {
    $this->SetTime($label);
    $this->SetUsage($label, $format);
  }

  /**
   * Get time difference.
   */
  protected function TimeDiff($plabel, $slabel) {
    // Get values.
    $plabel = $plabel . '_time';
    $slabel = $slabel . '_time';
    return $this->$slabel - $this->$plabel;
  }

  /**
   * Get usage difference.
   */
  protected function UsageDiff($plabel, $slabel) {
    // Get values.
    $plabel = $plabel . '_usage';
    $slabel = $slabel . '_usage';
    return $this->GetrusageDiff($this->$plabel, $this->$slabel);
  }

  /**
   * Get stats.
   * @param
   *  $plabel: Primary label. Should be set prior to secondary label.
   * @param
   *  $slabel: Secondary label. Should be set after primary label.
   */
  public function CheckGati($plabel, $slabel) {
    try {
      $time = $usage = NULL;
      $time = $this->TimeDiff($plabel, $slabel);
      $usage = $this->UsageDiff($plabel, $slabel);

      return array(
          'time' => $time,
          'usage' => $usage,
        );
    }
    catch(Exception $e) {
      return $e;
    }
  }

  /**
   * Get stats.
   * @param
   *  $plabel: Primary label. Should be set prior to secondary label.
   * @param
   *  $slabel: Secondary label. Should be set after primary label.
   */
  public function Report($plabel, $slabel) {
    try {
      $array = array();
      // Get results.
      $results = $this->CheckGati($plabel, $slabel);
      // Prepare array.
      $array['Clock time'] = $results['time'];
      $array['Time taken in User Mode'] = $results['usage']['ru_utime.tv'];
      $array['Time taken in System Mode'] = $results['usage']['ru_stime.tv'];
      $array['Maximum resident shared size'] = $results['usage']['ru_maxrss'];
      $array['Integral shared memory size'] = $results['usage']['ru_ixrss'];
      $array['Integral unshared data size'] = $results['usage']['ru_idrss'];
      $array['Integral unshared stack size'] = $results['usage']['ru_isrss'];
      $array['Number of page reclaims'] = $results['usage']['ru_minflt'];
      $array['Number of page faults'] = $results['usage']['ru_majflt'];
      $array['Number of block input operations'] = $results['usage']['ru_inblock'];
      $array['Number of block output operations'] = $results['usage']['ru_outblock'];
      $array['Number of messages sent'] = $results['usage']['ru_msgsnd'];
      $array['Number of messages received'] = $results['usage']['ru_msgrcv'];
      $array['Number of signals received'] = $results['usage']['ru_nsignals'];
      $array['Number of voluntary context switches'] = $results['usage']['ru_nvcsw'];
      $array['Number of involuntary context switches'] = $results['usage']['ru_nivcsw'];
      return $array;
    }
    catch(Exception $e) {
      return $e;
    }
  }
  
  /**
   * Get difference of arrays with keys intact.
   */
  private function GetrusageDiff($arr1, $arr2) {
    $array = array();
    // Add user mode time.
    $arr1['ru_utime.tv'] = ($arr1['ru_utime.tv_usec']/1000000) + $arr1['ru_utime.tv_sec'];
    $arr2['ru_utime.tv'] = ($arr2['ru_utime.tv_usec']/1000000) + $arr2['ru_utime.tv_sec'];
    // Add system mode time.
    $arr1['ru_stime.tv'] = ($arr1['ru_stime.tv_usec']/1000000) + $arr1['ru_stime.tv_sec'];
    $arr2['ru_stime.tv'] = ($arr2['ru_stime.tv_usec']/1000000) + $arr2['ru_stime.tv_sec'];

    // Unset time splits.
    unset($arr1['ru_utime.tv_usec']);
    unset($arr1['ru_utime.tv_sec']);
    unset($arr2['ru_utime.tv_usec']);
    unset($arr2['ru_utime.tv_sec']);
    unset($arr1['ru_stime.tv_usec']);
    unset($arr1['ru_stime.tv_sec']);
    unset($arr2['ru_stime.tv_usec']);
    unset($arr2['ru_stime.tv_sec']);

    // Iterate over values.
    foreach ($arr1 as $key => $value) {
      $array[$key] = $arr2[$key] - $arr1[$key];
    }
    return $array;
  }

}