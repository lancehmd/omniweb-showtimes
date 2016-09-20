<?php
/*
Admin Page Framework
*/

if (!class_exists('OmniwebShowtimes_AdminPageFramework_Registry', false)):
    abstract class OmniwebShowtimes_AdminPageFramework_Registry_Base {
        const VERSION = '3.8.1';
        const NAME = 'Admin Page Framework';
        const DESCRIPTION = 'Facilitates WordPress plugin and theme development.';
        const URI = 'http://en.michaeluno.jp/admin-page-framework';
        const AUTHOR = 'Michael Uno';
        const AUTHOR_URI = 'http://en.michaeluno.jp/';
        const COPYRIGHT = 'Copyright (c) 2013-2016, Michael Uno';
        const LICENSE = 'MIT <http://opensource.org/licenses/MIT>';
        const CONTRIBUTORS = '';
    }
    final class OmniwebShowtimes_AdminPageFramework_Registry extends OmniwebShowtimes_AdminPageFramework_Registry_Base {
        const TEXT_DOMAIN = 'admin-page-framework';
        const TEXT_DOMAIN_PATH = '/language';
        static public $bIsMinifiedVersion = true;
        static public $bIsDevelopmentVersion = true;
        static public $sAutoLoaderPath;
        static public $sIncludeClassListPath;
        static public $aClassFiles = array();
        static public $sFilePath = '';
        static public $sDirPath = '';
        static public function setUp($sFilePath = __FILE__) {
            self::$sFilePath = $sFilePath;
            self::$sDirPath = dirname(self::$sFilePath);
            self::$sIncludeClassListPath = self::$sDirPath . '/admin-page-framework-include-class-list.php';
            self::$aClassFiles = self::_getClassFilePathList(self::$sIncludeClassListPath);
            self::$sAutoLoaderPath = isset(self::$aClassFiles['OmniwebShowtimes_AdminPageFramework_RegisterClasses']) ? self::$aClassFiles['OmniwebShowtimes_AdminPageFramework_RegisterClasses'] : '';
            self::$bIsMinifiedVersion = class_exists('OmniwebShowtimes_AdminPageFramework_MinifiedVersionHeader', false);
            self::$bIsDevelopmentVersion = isset(self::$aClassFiles['OmniwebShowtimes_AdminPageFramework_InclusionClassFilesHeader']);
        }
        static private function _getClassFilePathList($sInclusionClassListPath) {
            $aClassFiles = array();
            include ($sInclusionClassListPath);
            return $aClassFiles;
        }
        static public function getVersion() {
            if (!isset(self::$sAutoLoaderPath)) {
                trigger_error('Admin Page Framework: ' . ' : ' . sprintf(__('The method is called too early. Perform <code>%2$s</code> earlier.', 'admin-page-framework'), __METHOD__, 'setUp()'), E_USER_WARNING);
                return self::VERSION;
            }
            $_aMinifiedVesionSuffix = array(0 => '', 1 => '.min',);
            $_aDevelopmentVersionSuffix = array(0 => '', 1 => '.dev',);
            return self::VERSION . $_aMinifiedVesionSuffix[( integer )self::$bIsMinifiedVersion] . $_aDevelopmentVersionSuffix[( integer )self::$bIsDevelopmentVersion];
        }
        static public function getInfo() {
            $_oReflection = new ReflectionClass(__CLASS__);
            return $_oReflection->getConstants() + $_oReflection->getStaticProperties();
        }
    }
endif;
if (!class_exists('OmniwebShowtimes_AdminPageFramework_Bootstrap', false)):
    final class OmniwebShowtimes_AdminPageFramework_Bootstrap {
        static private $_bLoaded = false;
        public function __construct($sLibraryPath) {
            if (!$this->_isLoadable()) {
                return;
            }
            OmniwebShowtimes_AdminPageFramework_Registry::setUp($sLibraryPath);
            if (OmniwebShowtimes_AdminPageFramework_Registry::$bIsMinifiedVersion) {
                return;
            }
            $this->_include();
        }
        private function _isLoadable() {
            if (self::$_bLoaded) {
                return false;
            }
            self::$_bLoaded = true;
            return defined('ABSPATH');
        }
        private function _include() {
            include (OmniwebShowtimes_AdminPageFramework_Registry::$sAutoLoaderPath);
            new OmniwebShowtimes_AdminPageFramework_RegisterClasses('', array('exclude_class_names' => array('OmniwebShowtimes_AdminPageFramework_MinifiedVersionHeader', 'OmniwebShowtimes_AdminPageFramework_BeautifiedVersionHeader',),), OmniwebShowtimes_AdminPageFramework_Registry::$aClassFiles);
            self::$_bXDebug = isset(self::$_bXDebug) ? self::$_bXDebug : extension_loaded('xdebug');
            if (self::$_bXDebug) {
                new OmniwebShowtimes_AdminPageFramework_Utility;
                new OmniwebShowtimes_AdminPageFramework_WPUtility;
            }
        }
        static private $_bXDebug;
    }
    new OmniwebShowtimes_AdminPageFramework_Bootstrap(__FILE__);
endif;