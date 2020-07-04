<?php

/**
 * Performance gauger to measure PHP applications
 * 
 * Based on http://github.com/fotuzlab/appgati, updated to modern standards
 * and better practices
 * 
 * @author Subiabre http://github.com/subiabre
 */
class AppGati
{
  public const EXISTING_STEP_EXCEPTION = "Tried to add a new step with the same label as an already existing step.";

  /**
   * @var array
   */
  private $steps = [];

  /**
   * Get the current time in microseconds
   * @return float Time in microseconds
   */
  public function getTime(): float
  {
    return \microtime(true);
  }

  /**
   * Get the current memory usage of PHP
   * @return int The memory usage in bytes
   */
  public function getMemory(): int
  {
    return \memory_get_usage();
  }

  /**
   * Get the peak memory usage of PHP
   * @return float The memory peak in bytes
   */
  public function getMemoryPeak(): int
  {
    return \memory_get_peak_usage(true);
  }

  /**
   * Add a new labeled step for measure
   * @param string $label Name for the step
   * @throws Exception If two steps with the same label are added
   * @return array
   */
  public function step(string $label): ?array
  {
    if (\array_key_exists($label, $this->steps))
    {
      throw new Exception(self::EXISTING_STEP_EXCEPTION, 1);
      return null;
    }

    $step = [
      'time' => $this->getTime(),
      'memory' => $this->getMemory(),
      'peak_memory' => $this->getMemoryPeak()
    ];

    $this->steps[$label] = $step;

    return $step;
  }

  /**
   * Get the steps data
   * @return array
   */
  public function getSteps(): array
  {
    return $this->steps;
  }

  /**
   * Get the time difference between two steps
   * @param string $primaryLabel Label to measure time against
   * @param string $secondaryLabel Label to compare time against primary
   * @return float Time difference in microseconds
   */
  public function getTimeDifference(string $primaryLabel, string $secondaryLabel): float
  {
    return $this->steps[$secondaryLabel]['time'] - $this->steps[$primaryLabel]['time'];
  }

  /**
   * Get the memory difference between two steps
   * @param string $primaryLabel Label to measure memory against
   * @param string $secondaryLabel Label to compare time against primary
   * @return float Memory difference in bytes
   */
  public function getMemoryDifference(string $primaryLabel, string $secondaryLabel): float
  {
    $memoryDiff = $this->steps[$secondaryLabel]['memory'] - $this->steps[$primaryLabel]['memory'];

    return $memoryDiff;
  }
}
