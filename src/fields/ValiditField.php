<?php
/**
 * Validit plugin for Craft CMS 3.x
 *
 * A super simple field type which allows you toggle existing field types.
 *
 * @link      https://fruitstudios.co.uk
 * @copyright Copyright (c) 2018 Fruit Studios
 */

namespace fruitstudios\validit\fields;

use fruitstudios\validit\Validit;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Fruit Studios
 * @package   Validit
 * @since     1.0.0
 */
class ValiditField extends Field
{
    // Public Properties
    // =========================================================================

    public $type;
    public $regex;
    public $message;

    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return Craft::t('validit', 'Validit');
    }

    // Public Methods
    // =========================================================================

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['type', 'required'];
        $rules[] = ['regex', 'string'];
        $rules[] = ['message', 'string'];
        return $rules;
    }

    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'validit/_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'validit/_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
            ]
        );
    }

    public function getTypes()
    {
        return [
            [
                'label' => Craft::t('validit', 'Email Address'),
                'value' => 'email',
            ],
            [
                'label' => Craft::t('validit', 'URL'),
                'value' => 'url',
            ],
            [
                'label' => Craft::t('validit', 'Telephone'),
                'value' => 'telephone',
            ],
            [
                'label' => Craft::t('validit', 'Facebook Url'),
                'value' => 'telephone',
            ],
            [
                'label' => Craft::t('validit', 'Twitter Url'),
                'value' => 'telephone',
            ],
            [
                'label' => Craft::t('validit', 'Instagram Url'),
                'value' => 'telephone',
            ],
            [
                'label' => Craft::t('validit', 'Custom Regex'),
                'value' => 'custom',
            ]
        ];
    }

}
