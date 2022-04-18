<?php

namespace Drupal\timeblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\timeblock\GetDateTimeService;


/**
 * Provides a 'DateTimeBlock' block.
 *
 * @Block(
 * id = "custom_date_time_block",
 * admin_label = @Translation("Date Time Block"),
 * )
 */

class DateTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
    
    /**
     * @var $account \Drupal\Core\Session\AccountProxyInterface
     */
    protected $customDateTimeService;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('timeblock.get_datetime_service')
        );
    }

    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param \Drupal\timeblock\GetDateTimeService $datetimeservice
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, GetDateTimeService $datetimeservice) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->customDateTimeService = $datetimeservice;
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $dynamicDateTime = $this->customDateTimeService->getDateTime();
        $timeZone = $this->customDateTimeService->getTimeZone();
        $build = [
            '#type' => 'markup',
            '#markup' => '<p>Datetime for timezone - ('. $timeZone .') is <b>'. $dynamicDateTime . '</b></p>',
        ];
        return $build;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge() {
        return 0;
    }
}
