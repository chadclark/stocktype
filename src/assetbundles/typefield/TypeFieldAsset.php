<?php
/**
 * Stocktype plugin for Craft CMS 3.x
 *
 * Custom fieldtype for M.F. Dulock order stock types.
 *
 * @link      https://github.com/chadclark
 * @copyright Copyright (c) 2020 Chad Clark
 */

namespace chadclark\stocktype\assetbundles\typefield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Chad Clark
 * @package   Stocktype
 * @since     1.0.0
 */
class TypeFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@chadclark/stocktype/assetbundles/typefield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Type.js',
        ];

        $this->css = [
            'css/Type.css',
        ];

        parent::init();
    }
}
