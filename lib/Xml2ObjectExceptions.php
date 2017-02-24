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
