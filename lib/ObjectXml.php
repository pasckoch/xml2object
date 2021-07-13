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

class ObjectXml
{

    protected $arrayXml;

    /**
     * @param $str
     * @return mixed
     */
    public function getObjectXml($str)
    {
        return (json_decode(json_encode($this->getArrayXml($str))));
    }

    /**
     * @param $str
     * @return array
     * @throws Exception
     */
    private function getArrayXml($str)
    {
        //on pointe sur le noeud message
        $element = $this->getNode($str);
        //création récursive du tableau
        $arrayXml = array();
        $this->makeArray($element, $arrayXml);
        $this->simpleArray($arrayXml);
        return $arrayXml;
    }

    /**
     * @param $str
     * @return \DOMNode|null
     * @throws Exception
     */
    private function getNode($str)
    {
        if ('' === (string)$str) {
            throw new Exception('Le xml est vide');
        }
        //création de l'objet dom element à partir du xml
        $xml = DomMechanism::dom($str, false, true);
        //on pointe sur le noeud message
        return $xml->getElementsByTagName('*')->item(0);
    }

    /**
     * @param $element
     * @param $arrayXml
     */
    private function makeArray(&$element, &$arrayXml)
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
     * @param $element
     * @param $arrayXml
     */
    private function attributesMakeArray(&$element, &$arrayXml)
    {
        //ajoute les variables de templates des attributes
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
