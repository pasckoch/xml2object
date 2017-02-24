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
