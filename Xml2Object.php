<?php

/**
 * A helper class for access parser xml or convert array to object and invert
 *
 * @author  Pascal Koch <info@pascalkoch.net>
 * @license https://github.com/pasckoch/xml2object/blob/master/LICENSE.txt BSD License
 */

namespace Xml2Object;

use Exception;

class Xml2Object
{
    /**
     * @param $filename
     * @return mixed
     * @throws Exception
     */
    public static function getObjectXmlByFilename($filename)
    {
        if (!is_file($filename)) {
            throw new Exception("File $filename doesn't exist.");
        }
        if (sprintf("%u", filesize($filename)) < 1) {
            throw new Exception("File $filename is empty");
        }
        return self::getObjectXml(file_get_contents($filename));
    }

    /**
     * @param $xml
     * @return mixed
     * @throws Exception
     */
    public static function getObjectXml($xml)
    {
        require_once __DIR__. '/ObjectXml.php';
        $parser = new ObjectXml();
        return $parser->getObjectXml($xml);
    }

    /**
     * utilisation array multi dimensional to object
     * @param $array
     * @return mixed
     */
    public static function arrayToObject($array)
    {
        return (json_decode(json_encode($array)));
    }

    /**
     * utilisation simple array with numeric keys to object
     * @param $array
     * @param null $object
     * @return mixed|null
     */
    public static function simpleArrayToObject($array, $object = null)
    {
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param $object
     * @param array $arr
     * @return array
     */
    public static function objectToArray($object, $arr = array())
    {
        $a_Obj = is_object($object) ? get_object_vars($object) : $object;
        if (empty($a_Obj)) {
            return $arr;
        }
        foreach ($a_Obj as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? self::objectToArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }
}
