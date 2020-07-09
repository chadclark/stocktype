<?php

/**
 * Stocktype plugin for Craft CMS 3.x
 *
 * Custom fieldtype for M.F. Dulock order stock types.
 *
 * @link      https://github.com/chadclark
 * @copyright Copyright (c) 2020 Chad Clark
 */

namespace chadclark\stocktype\fields;

use chadclark\stocktype\Stocktype;
use chadclark\stocktype\assetbundles\typefield\TypeFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use GraphQL\Type\Definition\Type;
use chadclark\stocktype\gql\TypeFieldGenerator;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Chad Clark
 * @package   Stocktype
 * @since     1.0.0
 */
class Type extends Field
{
  // Public Properties
  // =========================================================================

  /**
   * @var string
   */
  public $someAttribute = 'Some Default';

  // Static Methods
  // =========================================================================

  /**
   * @inheritdoc
   */
  public static function displayName(): string
  {
    return Craft::t('stocktype', 'Stock Type');
  }

  // Public Methods
  // =========================================================================

  /**
   * @inheritdoc
   */
  public function rules()
  {
    $rules = parent::rules();
    $rules = array_merge($rules, [
      ['someAttribute', 'string'],
      ['someAttribute', 'default', 'value' => 'Some Default'],
    ]);
    return $rules;
  }

  /**
   * @inheritdoc
   */
  public function getContentColumnType(): string
  {
    //return Schema::TYPE_MIXED;
    return Schema::TYPE_TEXT;
  }

  /**
     * @inheritdoc
     * @since 3.3.0
     */
    public function getContentGqlType()
    {
        $typeArray = TypeFieldGenerator::generateTypes($this);

        return [
            'name' => $this->handle,
            'description' => "Stocktype field",
            'type' => array_shift($typeArray),
        ];
    }

  /**
   * @inheritdoc
   */
  public function normalizeValue($value, ElementInterface $element = null)
  {
    if (empty($value)) return null;
    if (is_array($value)) return $value;

    return Json::decodeIfJson($value);
  }

  /**
   * @inheritdoc
   */
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
      'stocktype/_components/fields/Type_settings',
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
    // Register our asset bundle
    Craft::$app->getView()->registerAssetBundle(TypeFieldAsset::class);

    // Get our id and namespace
    $id = Craft::$app->getView()->formatInputId($this->handle);
    $namespacedId = Craft::$app->getView()->namespaceInputId($id);

    // Variables to pass down to our field JavaScript to let it namespace properly
    $jsonVars = [
      'id' => $id,
      'name' => $this->handle,
      'namespace' => $namespacedId,
      'prefix' => Craft::$app->getView()->namespaceInputId(''),
    ];
    $jsonVars = Json::encode($jsonVars);
    Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').StocktypeType(" . $jsonVars . ");");

    $stockAttributes = Json::encode($value);
    // Render the input template
    return Craft::$app->getView()->renderTemplate(
      'stocktype/_components/fields/Type_input',
      [
        'name' => $this->handle,
        'value' => $value,
        'field' => $this,
        'id' => $id,
        'namespacedId' => $namespacedId,
        'stockAttributes' => $stockAttributes,
      ]
    );
  }
}
