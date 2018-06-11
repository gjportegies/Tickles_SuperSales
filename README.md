# Tickles_Supersales - A open source flashsales module for Magento 2


Supersales is a open source Magento 2 module to manage and display Flash sales.

  - Set own start/end date.
  - Uses special price of the product.
  - 2 Templates (1 for singular product/sale & 1 for a grid/collection of sales).
  - Select specific deal by identifier in XML by passing a sale_identifier argument.

# New Features

  - jQuery.countdown plugin as countdown



### Installation

Install module trough composer:

```sh
$ composer require tickles/supersales
$ bin/magento setup:upgrade
```

### Plugins

Supersales is currently extended with the following plugins. Links to their docs are listed below.

| Plugin | README |
| ------ | ------ |
| jQuery.countdown | [Documentation][PljC] |


### Todos
 - Use a sourcemodel to select the product ID from a selectpicker.
 - Add SCSS styling (for the users of a magento 2 SCSS theme like Snowdog's Blank Sass).
 - Add LESS styling to Work with (default) magento 2 LESS themes (like Luma).

### License

MIT

   [PljC]: <http://hilios.github.io/jQuery.countdown/documentation.html>
