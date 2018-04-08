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
    public $placeholder;

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
        $rules[] = [['type'], 'required'];
        $rules[] = [['regex'], 'string'];
        $rules[] = [['message'], 'string'];
        $rules[] = [['placeholder'], 'string'];
        return $rules;
    }

    public function getElementValidationRules(): array
    {
        $message = !empty($this->message) ? $this->message : Craft::t('validit', 'Please provide a valid {type}', [
            'type' => $this->type
        ]);

        switch($this->type)
        {
            case('email'):
                $rule = ['email', 'message' => $message];
                break;
            case('url'):
                $rule = [ValiditUrlValidator::class, 'defaultScheme' => 'http', 'message' => $message];
                break;
            case('tel'):
                $match = '/^(?:\+\d{1,3}|0\d{1,3}|00\d{1,2})?(?:\s?\(\d+\))?(?:[-\/\s.]|\d)+$/';
                $rule = ['match', 'pattern' => $match, 'message' => $message];
                break;
            case('ip'):
                $rule = ['ip', 'message' => $message];
                break;
            case('ipv4'):
                $rule = ['ip', 'ipv6' => false, 'message' => $message];
                break;
            case('ipv6'):
                $rule = ['ip', 'ipv4' => false, 'message' => $message];
                break;
            case('facebook'):
                $match = '/(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?/';
                $rule = ['match', 'pattern' => $match, 'message' => $message];
                break;
            case('twitter'):
                $match = '/^http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/';
                $rule = ['match', 'pattern' => $match, 'message' => $message];
                break;
            case('instagram'):
                $match = '/(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am)\/([A-Za-z0-9-_]+)/i';
                $rule = ['match', 'pattern' => $match, 'message' => $message];
                break;
            case('linkedin'):
                $match = '/^http(?:s)?:\/\/[a-z]{2,3}\\.linkedin\\.com\\/.*$/';
                $rule = ['match', 'pattern' => $match, 'message' => $message];
                break;
            case('custom'):
                $rule = ['match', 'pattern' => $this->regex, 'message' => $message];
                break;
            default:
                $rule = null;
                break;
        }

        return [$rule];
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
                'id' => $id,
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
            ]
        );
    }

    public function getTypes()
    {

        return [
            'email' => [
                'label' => Craft::t('validit', 'Email Address'),
                'placeholder' => Craft::t('validit', 'email@domain.com'),
                'handle' => 'email',
            ],
            'url' => [
                'label' => Craft::t('validit', 'URL'),
                'placeholder' => Craft::t('validit', 'https://domain.com'),
                'handle' => 'url',
            ],
            'telephone' => [
                'label' => Craft::t('validit', 'Telephone'),
                'placeholder' => Craft::t('validit', '+44(0)0000 000000'),
                'handle' => 'telephone',
            ],
            'ip' => [
                'label' => Craft::t('validit', 'IP Address (Any)'),
                'placeholder' => Craft::t('validit', '192.168.0.1, 2001:0db8:85a3:0000:0000:8a2e:0370:7334'),
                'handle' => 'ip',
            ],
            'ipv4' => [
                'label' => Craft::t('validit', 'IP Address (IPV4)'),
                'placeholder' => Craft::t('validit', '192.168.0.1'),
                'handle' => 'ipv4',
            ],
            'ipv6' => [
                'label' => Craft::t('validit', 'IP Address (IPV6)'),
                'placeholder' => Craft::t('validit', '2001:0db8:85a3:0000:0000:8a2e:0370:7334'),
                'handle' => 'ipv6',
            ],
            'facebook' => [
                'label' => Craft::t('validit', 'Facebook Url'),
                'placeholder' => Craft::t('validit', 'https://www.facebook.com/username'),
                'handle' => 'facebook',
            ],
            'twitter' => [
                'label' => Craft::t('validit', 'Twitter Url'),
                'placeholder' => Craft::t('validit', 'https://twitter.com/username'),
                'handle' => 'twitter',
            ],
            'instagram' => [
                'label' => Craft::t('validit', 'Instagram Url'),
                'placeholder' => Craft::t('validit', 'https://www.instagram.com/username'),
                'handle' => 'instagram',
            ],
            'linkedin' => [
                'label' => Craft::t('validit', 'LinkedIn Url'),
                'placeholder' => Craft::t('validit', 'https://www.linkedin.com/in/username'),
                'handle' => 'linkedin',
            ],
            'custom' => [
                'label' => Craft::t('validit', 'Custom Regex'),
                'placeholder' => Craft::t('validit', $this->name),
                'handle' => 'custom',
            ]
        ];
    }

    public function getTypeOptions()
    {
        $options = [];
        foreach ($this->getTypes() as $type => $value)
        {
            $options[] = [
                'label' => $type->label,
                'value' => $type->handle,
            ];
        }
        return $options;
    }

}
