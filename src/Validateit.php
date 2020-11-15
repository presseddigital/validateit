<?php
/**
 * Validateit plugin for Craft CMS 3.x
 *
 * A super simple field type which allows you toggle existing field types.
 *
 * @link      https://pressed.digital
 * @copyright Copyright (c) 2018 Pressed Digital
 */

namespace presseddigital\validateit;

use presseddigital\validateit\fields\ValidateitField;

use Craft;
use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Validateit
 *
 * @author    Pressed Digital
 * @package   Validateit
 * @since     1.0.0
 *
 */
class Validateit extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Validateit
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

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
                $event->types[] = ValidateitField::class;
            }
        );

        Craft::info(
            Craft::t(
                'validateit',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}
