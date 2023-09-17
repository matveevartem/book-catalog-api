#/bin/bash

cp ../../../../app/config/web.php ../../../../app/config/web.tmp
sed -i '/require __DIR__ . "\/..\/modules\/v1\/config\/web.php";/d' ../../../../app/config/web.tmp
sed '/return $config/ i\require __DIR__ . "/../modules/v1/config/web.php";' ../../../../app/config/web.tmp > ../../../../app/config/web.php
rm -f ../../../../app/config/web.tmp

cp ../../../../app/config/console.php ../../../../app/config/console.tmp
sed -i '/require __DIR__ . "\/..\/modules\/v1\/config\/console.php";/d' ../../../../app/config/console.tmp
sed '/return $config/ i\require __DIR__ . "/../modules/v1/config/console.php";' ../../../../app/config/console.tmp > ../../../../app/config/console.php
rm -f ../../../../app/config/console.tmp

cd ../../../tests
ln -s -f ../modules/v1/tests/functional.suite.yml v1.functional.suite.yml
ln -s -f ../modules/v1/tests/unit.suite.yml v1.unit.suite.yml
ln -s -f ../modules/v1/tests/functional v1.functional
ln -s -f ../modules/v1/tests/unit v1.unit
