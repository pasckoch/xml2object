<?php
namespace Xml2Object;
/*
 * The MIT License
 *
 * Copyright 2017 Pascal Koch <info@pascalkoch.net>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Parser Xml2Object
 *
 * @author Pascal Koch <info@pascalkoch.net>
 */
require_once __DIR__.'/lib/DomMechanism.php';
require_once __DIR__.'/lib/ObjectXml.php';
require_once __DIR__.'/lib/Xml2ObjectExceptions.php';

class Xml2Object {

    public static function getObjectXml($xml) {
        $ig = new ObjectXml;
        try {
            return $ig->getObjectXml($xml);
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function getObjectXmlByFilename($filename) {
        try {
            Xml2ObjectExceptions::isnotFile($filename);
            return self::getObjectXml(file_get_contents($filename));
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    //utilisation array multi dimensional to object
    public static function arrayToObject($array) {
        return (json_decode(json_encode($array)));
    }

    //utilisation simple array with numeric keys to object
    public static function simpleArrayToObject($array, $object = null) {
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function objectToArray($object, $arr = array()) {
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
