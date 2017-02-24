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
 * Description of Xml2ObjectExceptions
 *
 * @author Pascal Koch <info@pascalkoch.net>
 */
class Xml2ObjectExceptions {


    static function isnotEmpty($value, $message) {
        if (empty($value)) {
            throw new Exception($message);
        }
    }

    static function notInArray($value, $array, $message) {
        if (!in_array($value, $array)) {
             throw new Exception($message);
        }
    }

    static function isnotFile($filename) {
        if (!is_file($filename)) {
            throw new Exception("File $filename doesn't exist.");
        } elseif (sprintf("%u", filesize($filename)) < 1) {
            throw new Exception("File $filename is empty");
        }
    }

   
}
