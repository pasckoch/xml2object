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
 * Description of DomMechanism
 *
 * @author Pascal Koch <info@pascalkoch.net>
 */
class DomMechanism {
    
    const encoding='utf-8';
    
    public static function dom($schema, $preserveWhiteSpace = false, $isStr = false) {
        return self::xsdDoc($schema, $preserveWhiteSpace, $isStr);
    }

    public static function xsdDoc($schematic, $preserveWhiteSpace = false, $isStr = false) {
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

    public static function xsdPath($schemaName) {
        $xsdDoc = self::xsdDoc($schemaName);
        return new DOMXPath($xsdDoc);
    }

    public static function recursiveNode($objet, $callback, &$element, &$parameter) {
        foreach ($element->childNodes as $node) {
            if (in_array($node->nodeType, array(3, 8))) {
                continue;
            }

            call_user_func_array(array($objet, $callback), array(&$node, &$parameter));
        }
    }

    public static function templateVariablePath($element) {
        //obtient le chemin de la variable (var1.var2.var3) par remplacement du chemin du noeud
        return str_replace('/', '.', substr($element->getNodePath(), 1));
    }

    public static function html_specialchars_decode_encodeXml($str) {
        return(preg_replace_callback('#<(.*)>(.*)</(.*)>#m', 'self::_handle_html_specialchars_decode_encodeXml', $str));
    }

    public static function _handle_html_specialchars_decode_encodeXml($match) {
        return '<' . $match[1] . '>' . htmlspecialchars(htmlspecialchars_decode($match[2]), null, self::encoding) . '</' . $match[3] . '>';
    }

}
