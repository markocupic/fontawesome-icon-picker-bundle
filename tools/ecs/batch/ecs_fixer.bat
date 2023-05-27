:: Run easy-coding-standard (ecs) via this batch file inside your IDE e.g. PhpStorm (Windows only)
:: Install inside PhpStorm the  "Batch Script Support" plugin
cd..
cd..
cd..
cd..
cd..
cd..
php vendor\bin\ecs check vendor/markocupic/fontawesome-icon-picker-bundle/src --fix --config vendor/markocupic/fontawesome-icon-picker-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/fontawesome-icon-picker-bundle/contao --fix --config vendor/markocupic/fontawesome-icon-picker-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/fontawesome-icon-picker-bundle/config --fix --config vendor/markocupic/fontawesome-icon-picker-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/fontawesome-icon-picker-bundle/tests --fix --config vendor/markocupic/fontawesome-icon-picker-bundle/tools/ecs/config.php
