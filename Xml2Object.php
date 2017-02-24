<?php
namespace Xml2Object;
/*
 * Copyright (C) 2017 Pascal Koch <info@pascalkoch.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
