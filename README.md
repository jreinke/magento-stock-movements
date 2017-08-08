# Save stock movements of your Magento products

![Stock Movements](http://i.imgur.com/Tpt6B.jpg)

## Features

* Saves stock movements in a new tab on the product modification page

## Installation

### Magento CE 1.5.x, 1.6.x, 1.7.x, 1.8.x, 1.9.x

Install with [modgit](https://github.com/jreinke/modgit):

    $ cd /path/to/magento
    $ modgit init
    $ modgit add stock-movements https://github.com/jreinke/magento-stock-movements.git

or download package manually:

* Download latest version [here](https://github.com/jreinke/magento-stock-movements/archive/master.zip)
* Unzip in Magento root folder
* Clear cache

## Full overview

A full overview is available [here](http://www.bubblecode.net/en/2012/02/07/magento-save-product-stock-moves/).

## Removal script/cmd

Remove all extension files:

 rm -rf app/code/community/Bubble/StockMovements/
 rm app/etc/modules/Bubble_StockMovements.xml
 rm app/locale/en_US/Bubble_StockMovements.csv
 rm app/locale/fr_FR/Bubble_StockMovements.csv
 rm app/locale/pt_BR/Bubble_StockMovements.csv

Cleanup database:

 DROP TABLE `bubble_stock_movement`;
 DELETE FROM `core_resource` WHERE `code` = 'bubble_stockmovements_setup';
