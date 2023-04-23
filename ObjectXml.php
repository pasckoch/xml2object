<?php

/**
 * @author  Pascal Koch <info@pascalkoch.net>
 * @license https://github.com/pasckoch/xml2object/blob/master/LICENSE.txt BSD License
 */

namespace Xml2Object;

use DOMNode;
use Exception;

class ObjectXml
{
    /**
     * @param $xml
     * @return mixed
     * @throws Exception
     */
    public function getObjectXml($xml)
    {
        require_once __DIR__ . '/DomMechanism.php';
        return (json_decode(json_encode($this->convertXmlToArray($xml))));
    }

    /**
     * @param $xml
     * @return array
     * @throws Exception
     */
    private function convertXmlToArray($xml)
    {
        $arrayXml = array();
        $element = $this->getDomNode($xml);
        $this->makeArray($element, $arrayXml);
        $this->simpleArray($arrayXml);
        return $arrayXml;
    }

    /**
     * get the Root Node of the Dom Document based on the XML string
     * @param $xml
     * @return DOMNode|null
     * @throws Exception
     */
    private function getDomNode($xml)
    {
        if ('' === (string)$xml) {
            throw new Exception('Empty xml');
        }

        $domDocument = DomMechanism::dom($xml, false, true);
        $domNodeList = $domDocument->getElementsByTagName('*');
        return $domNodeList->item(0);
    }

    /**
     * @param $element
     * @param $arrayXml
     */
    public function makeArray(&$element, &$arrayXml)
    {
        $this->pushArrayXml($arrayXml, $element, $element->nodeName);

        $this->attributesMakeArray($element, $arrayXml[$element->nodeName]);
        if ($element->hasChildNodes() && $element->childNodes->item(0)->nodeType == 1) {
            DomMechanism::recursiveNode($this, __FUNCTION__, $element, $arrayXml[$element->nodeName][]);
        }
    }

    /**
     * @param $arrayXml
     * @param $node
     * @param $name
     */
    private function pushArrayXml(&$arrayXml, $node, $name)
    {
        if ($node->hasChildNodes() && $node->childNodes->item(0)->nodeType == 3) {
            $arrayXml[$name][] = $node->nodeValue;
        }
    }

    /**
     * add attributes and their values in the tree
     * @param $element
     * @param $arrayXml
     */
    private function attributesMakeArray(&$element, &$arrayXml)
    {
        foreach ($element->attributes as $attrName => $attrNode) {
            $this->pushArrayXml($arrayXml, $attrNode, $attrName);
        }
    }

    /**
     * @param $arrayXml
     */
    private function simpleArray(&$arrayXml)
    {
        if (is_array($arrayXml)) {
            foreach ($nodes = array_keys($arrayXml) as $key) {
                if (is_numeric($key) && count($nodes) == 1) {
                    $arrayXml = $arrayXml[0];
                    $this->simpleArray($arrayXml);
                    return;
                }
                $this->simpleArray($arrayXml[$key]);
            }
        }
    }
}
