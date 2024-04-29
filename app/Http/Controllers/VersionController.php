<?php
/**
 * autor      : jiweijian
 * createTime : 2024/1/3 16:35
 * description:
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Composer\Semver\Comparator;

class VersionController extends BaseController
{

    /**
     * 对比版本
     * composer require composer/semver
     * https://github.com/composer/semver
     * @return void
     */
    public function checkVersion()
    {
        echo '大于：'.Comparator::greaterThan('1.25.0', '1.24.0').'<br/>';
        echo '大于或等于：'.Comparator::greaterThanOrEqualTo('1.25.0', '1.24.0').'<br/>';

        echo '小于：'.Comparator::lessThan('1.25.0', '1.24.0').'<br/>';
        echo '小于或等于：'.Comparator::lessThanOrEqualTo('1.25.0', '1.24.0').'<br/>';
        echo '等于：'.Comparator::equalTo('1.25.0', '1.24.0').'<br/>';
        echo '不等于：'.Comparator::notEqualTo('1.25.0', '1.24.0').'<br/>';
    }
}