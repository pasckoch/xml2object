<?php

/**
 * @author  Pascal Koch <info@pascalkoch.net>
 * @license https://github.com/pasckoch/xml2object/blob/master/LICENSE.txt BSD License
 */

namespace Xml2Object\src;

use DOMDocument;
use DOMXPath;
use Exception;

class DomMechanism
{

    const ENCODING = 'utf-8';

    /**
     * @param $schema
     * @param false $preserveWhiteSpace
     * @param false $isStr
     * @return DOMDocument
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
     * @return DOMDocument
     * @throws Exception
     */
    public static function xsdDoc($schematic, $preserveWhiteSpace = false, $isStr = false)
    {
        $xsdDoc = new DOMDocument;
        $xsdDoc->preserveWhiteSpace = $preserveWhiteSpace;
        $schema = self::htmlSpecialCharsDecodeEncodeXml($schematic);
        if (!$isStr && !$xsdDoc->load($schema)) {
            throw new Exception("$schema introuvable");
        } elseif ($isStr && !$xsdDoc->loadXml($schema)) {
            throw new Exception(sprintf('Xml illisible %s', $schema));
        }
        return $xsdDoc;
    }

    /**
     * @param $str
     * @return array|string|string[]|null
     */
    public static function htmlSpecialCharsDecodeEncodeXml($str)
    {
        return (preg_replace_callback('#<(.*)>(.*)</(.*)>#m', 'self::handleHtmlSpecialCharsDecodeEncodeXml',
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
    public static function handleHtmlSpecialCharsDecodeEncodeXml($match)
    {
        return '<' . $match[1] . '>' . htmlspecialchars(htmlspecialchars_decode($match[2]), null,
                self::ENCODING) . '</' . $match[3] . '>';
    }

}
