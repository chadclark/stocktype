<?php
/**
 * Stocktype plugin for Craft CMS 3.x
 *
 * Custom fieldtype for M.F. Dulock order stock types.
 *
 * @link      https://github.com/chadclark
 * @copyright Copyright (c) 2020 Chad Clark
 */

namespace chadclark\stocktype;

use chadclark\stocktype\fields\Type as TypeField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Stocktype
 *
 * @author    Chad Clark
 * @package   Stocktype
 * @since     1.0.0
 *
 */
class Stocktype extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Stocktype
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = TypeField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'stocktype',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
