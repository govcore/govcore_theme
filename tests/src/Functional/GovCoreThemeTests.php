<?php

namespace Drupal\Tests\govcore_theme\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\language\Entity\ConfigurableLanguage;
use Drupal\Core\Cache\Cache;

/**
 * govcore_theme Tests.
 *
 * @group govcore_theme
 */
class govcore_themeTests extends BrowserTestBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'bartik';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'toolbar',
    'language',
    'config_translation',
    'content_translation',
    'locale',
    'node',
    'system',
    'user',
    'block',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->drupalLogin($this->rootUser);

    \Drupal::service('theme_installer')->install(['govcore_theme']);

    \Drupal::configFactory()
      ->getEditable('system.theme')
      ->set('admin', 'govcore_theme')
      ->save();

    ConfigurableLanguage::createFromLangcode('ar')->save();
    Cache::invalidateTags(['rendered', 'locale']);
  }

  /**
   * Check govcore_theme blocks.
   */
  public function testCheckgovcore_themeBlocks() {
    $assert_session = $this->assertSession();

    $this->drupalLogin($this->rootUser);

    // govcore_theme blocks.
    $this->drupalGet('/admin/structure/block/list/govcore_theme');

    $assert_session->pageTextContains($this->t('Page title'));
    $assert_session->pageTextContains($this->t('Primary tabs'));
    $assert_session->pageTextContains($this->t('Secondary tabs'));
    $assert_session->pageTextContains($this->t('Breadcrumbs'));
    $assert_session->pageTextContains($this->t('Status messages'));
    $assert_session->pageTextContains($this->t('Help'));
    $assert_session->pageTextContains($this->t('Primary admin actions'));
    $assert_session->pageTextContains($this->t('Main page content'));
  }

}
