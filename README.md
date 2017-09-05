# HetwanPHP
Dofus 1.29 emulator in PHP

# Installation
$> php composer.phar install

# Generate database
At the root of the project:
$> vendor/bin/doctrine orm:schema-tool:update --dump-sql --force

# Launch
$> php Hetwan.php
