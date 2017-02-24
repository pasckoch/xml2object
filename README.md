The DOM extension required allows you to operate on XML documents through the DOM API with PHP. 

Certain Linux distributions do not have this extension included in the minimum PHP package. It can usually be found in one of the "optional" php-* packages.

For CentOS, you will need to run "yum install php-xml", which provides this extension.


# xml2object
    require "Xml2Object.php";

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