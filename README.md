# xml2object

You can get it with composer.

xml2object is a parser, a dOM analysis makes an object with an xml. The DOM extension is required.

The DOM extension required allows you to operate on XML documents through the DOM API with PHP. 

Certain Linux distributions do not have this extension included in the minimum PHP package. It can usually be found in one of the "optional" php-* packages.

For CentOS, you will need to run "yum install php-xml", which provides this extension.


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

This process architecture has been built.

    export 	
        object
        data 	
            array
                0 	
                    object
                    data1 	Telephone
                    data2 	220
                1 	
                    object
                    data1 	Tele
                    data2 	20
                2 	
                    object
                    data1 	Yep
                    data2 	120
                3 	
                    object
                    data1 	Frigo
                    data2 	20
                4 	
                    object
                    data1 	DVD
                    data2 	89
                5 	
                    object
                    data1 	Camescope
                    data2 	35