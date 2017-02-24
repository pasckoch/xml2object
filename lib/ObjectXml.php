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
