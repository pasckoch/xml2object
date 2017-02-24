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
 * Description of XmlObject
 *
 * @author Pascal Koch <info@pascalkoch.net>
 */
class ObjectXml {

    protected $arrayXml;

    public function getObjectXml($str) {
        return(json_decode(json_encode($this->getArrayXml($str))));
    }

    public function getNode($str) {
        Xml2ObjectExceptions::isnotEmpty($str, 'le Xml est vide', __CLASS__, __FUNCTION__);
        //cr�ation de l'objet dom element � partir du xml
        $xml = DomMechanism::dom($str, false, true);
        //on pointe sur le noeud message
        return $xml->getElementsByTagName('*')->item(0);
    }

    public function getArrayXml($str) {
        try {
            //on pointe sur le noeud message
            $element = $this->getNode($str);
            //cr�ation r�cursive du tableau
            $arrayXml = array();
            $this->makeArray($element, $arrayXml);
            $this->simpleArray($arrayXml);
            return $arrayXml;
        } catch (Exception $ex) {
            IGspnExceptions::action($ex);
        }
    }

    public function pushArrayXml(&$arrayXml, $node, $name) {
        if ($node->hasChildNodes() && $node->childNodes->item(0)->nodeType == 3) {
            $arrayXml[$name][] = $node->nodeValue;
        }
    }

    public function attributesMakeArray(&$element, &$arrayXml) {
        //ajoute les variables de templates des attributes 
        foreach ($element->attributes as $attrName => $attrNode) {
            $this->pushArrayXml($arrayXml, $attrNode, $attrName);
        }
    }

    public function makeArray(&$element, &$arrayXml) {
        $this->pushArrayXml($arrayXml, $element, $element->nodeName);

        $this->attributesMakeArray($element, $arrayXml[$element->nodeName]);
        if ($element->hasChildNodes() && $element->childNodes->item(0)->nodeType == 1) {
            DomMechanism::recursiveNode($this, __FUNCTION__, $element, $arrayXml[$element->nodeName][]);
        }
    }

    public function simpleArray(&$arrayXml) {
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
