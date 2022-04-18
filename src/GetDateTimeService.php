<?php

namespace Drupal\timeblock;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Class GetDateTimeService
 * @package Drupal\timeblock\Services
 */
class GetDateTimeService {

  /**
   * Config Factory Service Object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The datetime.time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $timeService;

  /**
   * Date Formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * GetDateTimeService constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Component\Datetime\TimeInterface $time_service
   *   The time service.
   * @param \Drupal\Core\Datetime\DateFormatter $date_formatter
   *   The date formatter service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, TimeInterface $time_service, DateFormatter $date_formatter) {
    $this->configFactory = $config_factory;
    $this->timeService = $time_service;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('datetime.time'),
      $container->get('date.formatter')
    );
  }


  /**
   * Returns the datetime string based on the timezone in the configuration.
   */
  public function getDateTime() {
    $config = $this->configFactory->get('timeblock.settings');  
    $configFactoryTimezone = $config->get('timezone');
    $systemTimestamp = $this->timeService->getCurrentTime();
    $resultDateTime = $this->dateFormatter->format(
        $systemTimestamp, 'custom', 'dS M Y - h:i A', $configFactoryTimezone
    );
    return $resultDateTime;
  }

  /**
   * Returns the timezone in the configuration.
   */
  public function getTimeZone() {
    $config = $this->configFactory->get('timeblock.settings');  
    $configFactoryTimezone = $config->get('timezone');
    return $configFactoryTimezone;
  }

}