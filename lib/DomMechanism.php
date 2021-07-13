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
 * @author Pascal Koch <info@pascalkoch.net>
 */

use Exception;
use DOMXPath;

class DomMechanism
{

    const ENCODING = 'utf-8';

    /**
     * @param $schema
     * @param false $preserveWhiteSpace
     * @param false $isStr
     * @return \DOMDocument
     * @throws Exception
     */
    public static function dom($schema, $preserveWhiteSpace = false, $isStr = false)
    {
        return self::xsdDoc($schema, $preserveWhiteSpace, $isStr);
    }

    /**
     * @param $schematic
     * @param false $preserveWhiteSpace
     * @param false $isStr
     * @return \DOMDocument
     * @throws Exception
     */
    public static function xsdDoc($schematic, $preserveWhiteSpace = false, $isStr = false)
    {
        $xsdDoc = new \DOMDocument;
        $xsdDoc->preserveWhiteSpace = $preserveWhiteSpace;
        $schema = self::html_specialchars_decode_encodeXml($schematic);
        if (!$isStr && !$xsdDoc->load($schema)) {
            throw new Exception("$schema introuvable");
        } elseif ($isStr && !$xsdDoc->loadXml($schema)) {
            throw new Exception('Xml illisible' . $schema);
        }
        return $xsdDoc;
    }

    /**
     * @param $str
     * @return array|string|string[]|null
     */
    public static function html_specialchars_decode_encodeXml($str)
    {
        return (preg_replace_callback('#<(.*)>(.*)</(.*)>#m', 'self::_handle_html_specialchars_decode_encodeXml',
            $str));
    }

    /**
     * @param $schemaName
     * @return DOMXPath
     * @throws Exception
     */
    public static function xsdPath($schemaName)
    {
        $xsdDoc = self::xsdDoc($schemaName);
        return new DOMXPath($xsdDoc);
    }

    /**
     * @param $objet
     * @param $callback
     * @param $element
     * @param $parameter
     */
    public static function recursiveNode($objet, $callback, &$element, &$parameter)
    {
        foreach ($element->childNodes as $node) {
            if (in_array($node->nodeType, array(3, 8))) {
                continue;
            }

            call_user_func_array(array($objet, $callback), array(&$node, &$parameter));
        }
    }

    /**
     * @param $element
     * @return array|false|string|string[]
     */
    public static function templateVariablePath($element)
    {
        //obtient le chemin de la variable (var1.var2.var3) par remplacement du chemin du noeud
        return str_replace('/', '.', substr($element->getNodePath(), 1));
    }

    /**
     * @param $match
     * @return string
     */
    public static function _handle_html_specialchars_decode_encodeXml($match)
    {
        return '<' . $match[1] . '>' . htmlspecialchars(htmlspecialchars_decode($match[2]), null,
                self::ENCODING) . '</' . $match[3] . '>';
    }

}
