<?php

namespace StartappTest;

use Startapp\InvalidParameterSettingException;
use Startapp\Params;

/**
 * Class ParamsTest
 * @package StartappTest
 */
class ParamsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testReturnsTheCorrectDate()
    {
        $params = new Params();
        $this->assertSame(date('y'), $params->getDate(), "Expected date not returned");
    }

    /**
     *
     */
    public function testLicenseTypes()
    {
        $this->assertSame(
            ['agpl', 'mit'],
            Params::ALLOWED_LICENSES,
            'Available license types not what was expected'
        );
    }

    public function testCanGetVersionStringsCorrectly()
    {
        $params = new Params();
        $this->assertSame('0.0.1', $params->getApplicationVersion());
        $this->assertSame('9.0', $params->getOwnCloudVersion());
    }

    /**
     * @dataProvider semVerDataProvider
     * @param $version
     * @param $status
     */
    public function testCanSetAndGetOwnCloudVersionCorrectly($version, $status)
    {
        $params = new Params();

        if (!$status) {
            $this->expectException(InvalidParameterSettingException::class);
            $this->expectExceptionMessage('Invalid version value supplied');
        }

        $params->setOwnCloudVersion($version);
        $this->assertSame($version, $params->getOwnCloudVersion());
    }

    /**
     * @dataProvider semVerDataProvider
     * @param $version
     * @param $status
     */
    public function testCanSetAndGetApplicationVersionCorrectly($version, $status)
    {
        $params = new Params();

        if (!$status) {
            $this->expectException(InvalidParameterSettingException::class);
            $this->expectExceptionMessage('Invalid version value supplied');
        }

        $params->setApplicationVersion($version);
        $this->assertSame($version, $params->getApplicationVersion());
    }

    public function semVerDataProvider()
    {
        return [
            ['', false],
            [null, false],
        ];
    }

    /**
     *
     */
    public function testAllowedCategories()
    {
        $this->assertSame(
            [
                'multimedia',
                'tool',
                'pim',
                'other',
                'game',
                'productivity'
            ],
            Params::ALLOWED_CATEGORIES,
            'Available categories not what was expected'
        );
    }

    /**
     *
     */
    public function testDefaultAppVersion()
    {
        $this->assertSame(Params::DEFAULT_APP_VERSION, '0.0.1');
    }

    /**
     *
     */
    public function testDefaultOwnCloudVersion()
    {
        $this->assertSame(Params::DEFAULT_OWNCLOUD_VERSION, '9.0');
    }

    /**
     *
     */
    public function testDefaultLicense()
    {
        $this->assertSame(Params::DEFAULT_LICENSE, 'agpl');
    }

    /**
     * @dataProvider nameDataProvider
     * @param $name
     * @param $valid
     */
    public function testCanSetNameCorrectly($name, $valid)
    {
        if (!$valid) {
            $this->expectException(InvalidParameterSettingException::class);
            $this->expectExceptionMessage('Invalid value for name supplied');
        }

        $params = new Params();
        $params->setName($name);
    }

    /**
     * @return array
     */
    public function nameDataProvider()
    {
        return [
            [
                'MyApp',
                true
            ],
            [
                'MyApp21',
                false
            ],
            [
                '21',
                false
            ],
            [
                '_lulbot__',
                false
            ]
        ];
    }

    /**
     * @dataProvider licenseDataProvider
     * @param $license
     * @param $valid
     */
    public function testLicenseCanOnlyBeSetToValidValue($license, $valid)
    {
        if (!$valid) {
            $this->expectException(InvalidParameterSettingException::class);
            $this->expectExceptionMessage('Invalid value for license supplied');
        }

        $params = new Params();
        $params->setLicense($license);
    }

    /**
     * @return array
     */
    public function licenseDataProvider()
    {
        return [
            [
                'agpl',
                true
            ],
            [
                'mit',
                true
            ],
            [
                'gpl',
                false
            ],
            [
                'ngpl',
                false
            ],
            [
                '',
                false
            ],
        ];
    }

    /**
     * @dataProvider categoryDataProvider
     * @param $category
     * @param $valid
     */
    public function testCategoryCanOnlyBeSetToValidValue($category, $valid)
    {
        if (!$valid) {
            $this->expectException(InvalidParameterSettingException::class);
            $this->expectExceptionMessage('Invalid value for category supplied');
        }

        $params = new Params();
        $params->setCategory($category);
    }

    /**
     * @return array
     */
    public function categoryDataProvider()
    {
        return [
            [
                'multimedia',
                true
            ],
            [
                'tool',
                true
            ],
            [
                'pim',
                true
            ],
            [
                'other',
                true
            ],
            [
                'game',
                true
            ],
            [
                'productivity',
                true
            ],
        ];
    }
}
