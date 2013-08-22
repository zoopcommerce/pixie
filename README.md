pixie
=====

Pixie provides tools to assist using composer to install dojo, mystique, havok and other asset libraries.

Dojo
----

To install dojo with composer add the following to your root composer.json:

    "repositories": [{ "type": "composer", "url": "http://zoopcommerce.github.io/pixie"}]

Then you can require dojo packages like this:

    "require": {
        "dojo/dojo"   : "~1.9",
        "dojo/dijit"  : "~1.9",
        "dojo/dojox"  : "~1.9",
        "dojo/util"   : "~1.9"
    }

If your root composer.json has an zoop-js-path defined in the extra key, then the dojo packages will be symlinked to that directory. Eg:

    "extra": {
        "zoop-js-path": "public/js"
    }

Havok and Mystique
------------------

Havok and Mystique are libraries from zoop which fully support composer and utilise these pixie installers.

Other Asset Libraries
---------------------

You can use the pixie js installer by adding

    "type": "zoop-js"
    "require": {
        "zoopcommerce/pixie": "*"
    }

to a package composer.json. Then if the project's root composer.json defines

    "extra": {
        "zoop-js-path": "public/js"
    }

the package will be symlinked to the defined js path.
