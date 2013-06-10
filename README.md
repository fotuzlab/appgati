appgati
=======

Script to gauge PHP application's performance.

What is appgati?
================

This script provides an array of following insights about your code:

    Array
    (
        [Clock time in seconds] => 1.9502429962158
        [Time taken in User Mode in seconds] => 0.632039
        [Time taken in System Mode in seconds] => 0.024001
        [Total time taken in Kernel in seconds] => 0.65604
        [Memory limit in MB] => 128
        [Memory usage in MB] => 18.237907409668
        [Peak memory usage in MB] => 19.579357147217
        [Average server load in last minute] => 0.47
        [Maximum resident shared size in KB] => 44900
        [Integral shared memory size] => 0
        [Integral unshared data size] => 0
        [Integral unshared stack size] => 
        [Number of page reclaims] => 12102
        [Number of page faults] => 6
        [Number of block input operations] => 192
        [Number of block output operations] => 
        [Number of messages sent] => 0
        [Number of messages received] => 0
        [Number of signals received] => 0
        [Number of voluntary context switches] => 606
        [Number of involuntary context switches] => 99
    )

Why appgati?
============

It uses simple PHP functions like memory_get_usage(), getrusage() etc and does some minor calculations for the developer.
Appgati allows the developer to define steps in the code and generate a report between the two steps which saves time, effort and provides a clean implementation.

Usage
=====

    // Add appgati.

    require_once 'appgati.class.php';

    // Initialize
    $app = new AppGati();

    // Add step.
    // A step should be a continous string.
    $app->Step('1');

    // Do some code...

    // Add another step.
    $app->Step('2');

    // Do some code...

    // Add another step.
    $app->Step('3');
    
    // Generate report between steps 1 and 2.
    // Input the steps sequentially as strings for correct reports.
    $report1 = $app->Report('1', '2');
    // Generate report between steps 2 and 3.
    $report2 = $app->Report('2', '3');

    // Print reports.
    print_r($report1);
    print_r($report2);

Outputs:

    Array
    (
        [Clock time in seconds] => 1.9502429962158
        [Time taken in User Mode in seconds] => 0.632039
        [Time taken in System Mode in seconds] => 0.024001
        [Total time taken in Kernel in seconds] => 0.65604
        [Memory limit in MB] => 128
        [Memory usage in MB] => 18.237907409668
        [Peak memory usage in MB] => 19.579357147217
        [Average server load in last minute] => 0.47
        [Maximum resident shared size in KB] => 44900
        [Integral shared memory size] => 0
        [Integral unshared data size] => 0
        [Integral unshared stack size] => 
        [Number of page reclaims] => 12102
        [Number of page faults] => 6
        [Number of block input operations] => 192
        [Number of block output operations] => 
        [Number of messages sent] => 0
        [Number of messages received] => 0
        [Number of signals received] => 0
        [Number of voluntary context switches] => 606
        [Number of involuntary context switches] => 99
    )
    
    Array
    (
        [Clock time in seconds] => 0.30258512496948
        [Time taken in User Mode in seconds] => 0.068004
        [Time taken in System Mode in seconds] => 0.012
        [Total time taken in Kernel in seconds] => 0.080004
        [Memory limit in MB] => 128
        [Memory usage in MB] => 3.9967918395996
        [Peak memory usage in MB] => 4.3335151672363
        [Average server load in last minute] => 0.47
        [Maximum resident shared size in KB] => 21040
        [Integral shared memory size] => 0
        [Integral unshared data size] => 0
        [Integral unshared stack size] => 
        [Number of page reclaims] => 5454
        [Number of page faults] => 0
        [Number of block input operations] => 0
        [Number of block output operations] => 
        [Number of messages sent] => 0
        [Number of messages received] => 0
        [Number of signals received] => 0
        [Number of voluntary context switches] => 51
        [Number of involuntary context switches] => 10
    )


What else?
==========

Appgati also provides following methods:

1. setFormat('format')

    Sets output format for Usage(). Valid parameters are array(default), string and json.

2. Time()
    
    Returns time in microseconds.

3. Memory()
    
    Returns current memory usage.

4. ServerLoad()
    
    Returns average server load in last 1, 5 and 15 minutes.

5. Usage()
    
    Returns output of getrusage(). http://linux.die.net/man/2/getrusage

6. Step('label')
    
    Adds a step or a checkpoint to generate reports. Input a continous string as label.

7. CheckGati('step1', 'step2')
    
    Returns values of Time(), Memory(), Usage(), memory_get_peak_usage() between two steps with their raw keys.

8. Report('step1', 'step2')
    
    Same as CheckGati() but returns output with more readable keys.

Important
=========

This script is purely for development purpose and should not be included in production.
