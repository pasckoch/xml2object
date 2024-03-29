# xml2object

You can get it with composer or https://github.com/pasckoch/xml2object.

If you use Composer, you can install Xml2Object  with the following command:

`
composer require "pasckoch/xml2object=^2.0"
`

Xml2object is a parser, it converts xml to stdClass's objects by a DOM analysis. 
The DOM extension is required.

The DOM extension required allows you to operate on XML documents through the DOM API with PHP. 

Certain Linux distributions do not have this extension included in the minimum PHP package. It can usually be found in one of the "optional" php-* packages.

For CentOS, you will need to run "yum install php-xml", which provides this extension.


    require "Xml2Object.php";
    
    use \Xml2Object\Xml2Object;

    $xml = '<?xml version="1.0" encoding="UTF-8" ?>
        <export status="ok">
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
    $object= Xml2Object::getObjectXml($xml);

This process architecture has been built.

```		    
object(stdClass)#10 (1) {
  ["export"]=>
  object(stdClass)#6 (2) {
    ["status"]=>
    string(2) "ok"
    ["0"]=>
    object(stdClass)#11 (1) {
      ["data"]=>
      array(6) {
        [0]=>
        object(stdClass)#2 (2) {
          ["data1"]=>
          string(9) "Telephone"
          ["data2"]=>
          string(3) "220"
        }
        [1]=>
        object(stdClass)#7 (2) {
          ["data1"]=>
          string(4) "Tele"
          ["data2"]=>
          string(2) "20"
        }
        [2]=>
        object(stdClass)#5 (2) {
          ["data1"]=>
          string(3) "Yep"
          ["data2"]=>
          string(3) "120"
        }
        [3]=>
        object(stdClass)#12 (2) {
          ["data1"]=>
          string(5) "Frigo"
          ["data2"]=>
          string(2) "20"
        }
        [4]=>
        object(stdClass)#9 (2) {
          ["data1"]=>
          string(3) "DVD"
          ["data2"]=>
          string(2) "89"
        }
        [5]=>
        object(stdClass)#8 (2) {
          ["data1"]=>
          string(9) "Camescope"
          ["data2"]=>
          string(2) "35"
        }
      }
    }
  }
}
```
