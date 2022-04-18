<?php

/**
 * @file
 * Contains Drupal\timeblock\Form\SettingsForm.
 */

namespace Drupal\timeblock\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\timeblock\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timeblock.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('timeblock.settings');
    $form['country'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
      '#required' => TRUE
    );
    $form['city'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
      '#required' => TRUE
    );
    $form['timezone'] = array(
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#default_value' => $config->get('timezone'),
      '#options' => [
        'America/Chicago' => $this->t('America/Chicago'), 
        'America/New_York' => $this->t('America/New_York'), 
        'Asia/Tokyo' => $this->t('Asia/Tokyo'), 
        'Asia/Dubai' => $this->t('Asia/Dubai'), 
        'Asia/Kolkata' => $this->t('Asia/Kolkata'), 
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'), 
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London')
      ],
      '#required' => TRUE
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('timeblock.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    $data = \Drupal::service('timeblock.get_datetime_service')->getDateTime();
    \Drupal::messenger()->addMessage($data);
  }

}
