<?php
namespace App\Object;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Yaml;

class CustomTranslationObject {

    /**
     * Array Associatifs of translations
     * 
     */
    public static $indexationsObject = [];
    public static $indexations = [];
    public static $system_site_variabilization = "";
    public static $system_site_variabilization_default = "";
    public static $system_site_variabilization_path = "";
    public static $system_site_variabilization_theme_path = "";

    private $params;

    public function __construct(ParameterBagInterface $params){
        $this->params = $params;
    }

    /**
     * initialization of static property
     * ONLY NO STATIC
     */
    public function initStaticProperty(){
        CustomTranslationObject::$system_site_variabilization = $this->params->get('SYSTEM_SITE_VARIABILIZATION') ;
        CustomTranslationObject::$system_site_variabilization_default = $this->params->get('SYSTEM_SITE_VARIABILIZATION_DEFAULT') ;
        CustomTranslationObject::$system_site_variabilization_path = $this->params->get('SYSTEM_SITE_VARIABILIZATION_PATH') ;
        CustomTranslationObject::$system_site_variabilization_theme_path = $this->params->get('SYSTEM_SITE_VARIABILIZATION_THEME_PATH') ;
        
        return true;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getSystemSiteVariabilization() {
        return self::$system_site_variabilization ;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getSystemSiteVariabilizationDefault() {
        return self::$system_site_variabilization_default ;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getSystemSiteVariabilizationPath() {
        return self::$system_site_variabilization_path ;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getActiveSystemSiteVariabilization() {
        $system_site_variabilization = self::getSystemSiteVariabilization() ;
        $system_site_variabilization_default = self::getSystemSiteVariabilizationDefault() ;
        $system_site_variabilization_path = self::getSystemSiteVariabilizationPath() ;

        $system_site_variabilization_path_of_site = $system_site_variabilization_path."/".$system_site_variabilization."/" ;

        if (
            file_exists($system_site_variabilization_path_of_site) &&
            is_dir($system_site_variabilization_path_of_site)
        ) {
            $active_system_site_variablization = $system_site_variabilization ;
        } else {
            $active_system_site_variablization = $system_site_variabilization_default ;
        }
        return $active_system_site_variablization ;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getActiveSystemSiteVariabilizationPath() {

        $system_site_variabilization_path = self::getSystemSiteVariabilizationPath() ;
        $active_system_site_variablization = self::getActiveSystemSiteVariabilization() ;

        $active_system_site_variabilization_path = $system_site_variabilization_path."/".$active_system_site_variablization."/" ;

        return $active_system_site_variabilization_path ;
    }

    /**
     * STATIC
     * To Generate key of path
     * @param string $path
     * @return string
     */
    public static function generateKeyOfPath($path) {
        $result = "" ;

        if (!$path) {
            return $result ;
        }

        $path = trim($path) ;
        // eg : path : file.yaml
        // eg : path : dir1/dir2/file.yaml
        $result = substr($path, 0, -5) ;
        // eg : path : dir1/dir2/file
        $result = str_replace("/", ".", $result) ;
        // eg : path : dir1.dir2.file
        return $result ;
    }

    /**
     * STATIC
     * @param string $path
     * @param boolean $is_in_object
     * @return []
     */
    public static function loadTranslationsInPath($path, $is_in_object=false) {

        if (!$path) {
            return false ;
        }

        $path = trim($path) ;
        // eg : path : file.yaml
        // eg : path : dir1/dir2/file.yaml

        $active_system_site_variabilization_path = self::getActiveSystemSiteVariabilizationPath() ;
        // eg : .../variabilization/{DEFAULT/SITE}/

        $path_to_file_yaml = $active_system_site_variabilization_path.$path ;
        // eg : .../variabilization/{DEFAULT/SITE}/file.yaml
        // eg : .../variabilization/{DEFAULT/SITE}/dir1/dir2/file.yaml

        if (
            !file_exists($path_to_file_yaml)
        ) {
            return false ;
        }

        $key_of_path = self::generateKeyOfPath($path) ;

        $mixed = [] ;

        try {
            $mixed = $value = Yaml::parseFile($path_to_file_yaml);
        } catch(ParseException $p) {
            echo $p->getMessage();
        }

        // tranformation
        $tranform_r = self::arrayMutliAssoToUniAsso($mixed, $key_of_path) ;

        // save to indexation
        if ($is_in_object) {
            self::$indexationsObject = array_merge(
                self::$indexationsObject, 
                $tranform_r
            );

            return self::$indexationsObject ;
        } else {
            self::$indexations = array_merge(
                self::$indexations, 
                $tranform_r
            );

            return self::$indexations ;
        }

    }

    /**
     * STATIC
     * @param []
     * @param string $key_of_path
     * @return mixed
     */
    public static function arrayMutliAssoToUniAsso($data = [], $key_of_path = "") {
        $separator = '.';
        $result = [];

        while ($data) {
            $value = reset($data);
            $key = key($data);
            unset($data[$key]);

            if (is_array($value)) {
                $build = [];
                foreach ($value as $subKey => $node) {
                    $build[$key . $separator . $subKey] = $node;
                }
                $data = $build + $data;
                continue;
            }

            if ($key !== "") {
                $key = $key_of_path . "." . $key;
                $result[$key] = self::replaceKeyInValue($value);
            }
        }

        return $result;
    }

    /**
     * STATIC
     * @param string
     * @return string
     */
    public static function replaceKeyInValue($value) {
        if (strpos($value, "%") !== 0) {
            return $value ;
        }
        $value_len = strlen($value) ;
        $value_len_1 = $value_len - 1 ;
        $start_pos = strpos($value, "%") ;
        $end_pos = strpos($value, "%", 1) ;
        $key = str_replace("%","", $value) ;
        if (
            $start_pos === 0 &&
            $end_pos === $value_len_1
        ) {
            if (
                isset(self::$indexations[$key])
            ) {
                return self::$indexations[$key] ;
            }
            if (
                isset(self::$indexationsObject[$key])
            ) {
                return self::$indexationsObject[$key] ;
            } else {
                return $value ;
            }
        } else {
            return $value ;
        }
    }

    /**
     * STATIC
     * @param [] $paths
     * @return boolean
     */
    public static function load($paths) {
        $result = true ;
        if ($paths) {

            if (is_array($paths)) {
                foreach ($paths as $key => $path) {
                    self::loadTranslationsInPath($path) ;
                }
            } else {
                self::loadTranslationsInPath($paths) ;
            }

        }

        return $result;
    }

    /**
     * STATIC
     * @param [] $paths
     * @return []
     */
    public static function get($paths) {
        $result = [] ;

        if ($paths) {

            if (is_array($paths)) {
                foreach ($paths as $key => $path) {
                    self::loadTranslationsInPath($path, true) ;
                }
            } else {
                self::loadTranslationsInPath($paths, true) ;
            }
            $result = self::$indexationsObject ;
        }

        self::$indexationsObject = [] ; // reset

        return $result;
        
    }

    /**
     * STATIC
     * @param string $key
     * @param [] $params
     * @return string
     */
    public static function customTranslate($key, $params=[]) {
        $result = "" ;
        $key = trim($key) ;

        if (!$key) {
            return $result ;
        }

        if (!isset(self::$indexations[$key])) {
            return $result ;
        }

        $result = self::$indexations[$key] ;

        if ($params) {
            foreach ($params as $param_key => $param_value) {
                $param_key = "{{".$param_key."}}" ;
                $result = str_replace($param_key, $param_value, $result) ;
            }
        }

        /* MAJ Too assets\utilities\functions\customTranslate.js */

        return $result;
    }

    /**
     * STATIC
     * @return string
     */
    public static function getEntryPointThemeOfSite() {
        $system_site_variabilization = CustomTranslationObject::getSystemSiteVariabilization() ;
        $entry_point_name = strtolower($system_site_variabilization)."_theme" ;
        $file_index_of_theme = CustomTranslationObject::$system_site_variabilization_theme_path."/".$system_site_variabilization."/index.js" ;
        if (
            !file_exists($file_index_of_theme)
        ) {
            return "default_theme" ;
        } else {
            return $entry_point_name ;
        }
    }

}
