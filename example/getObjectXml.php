<?php

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

require "../Xml2Object.php";

//example of xml
$xml = '<?xml version="1.0" encoding="UTF-8" ?>
<export>
	<data>
		<data1>Telephone</data1>
		<data2>220</data2>
	</data>
	<data>
		<data1>Tele</data1>
		<data2>20</data2>
	</data>
	<data>
		<data1>Yep</data1>
		<data2>120</data2>
	</data>
	<data>
		<data1>Frigo</data1>
		<data2>20</data2>
	</data>
	<data>
		<data1>DVD</data1>
		<data2>89</data2>
	</data>
	<data>
		<data1>Camescope</data1>
		<data2>35</data2>
	</data>
</export>';

//parse xml 2 object
$object= \Xml2Object\Xml2Object::getObjectXml($xml);
//visual in html
new \Ospinto\dBug($object);

