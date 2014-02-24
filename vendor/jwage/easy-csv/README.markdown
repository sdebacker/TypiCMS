EasyCSV
=======

EasyCSV is a simple Object Oriented CSV manipulation library for PHP 5.4+

[![Build Status](https://secure.travis-ci.org/jwage/easy-csv.png?branch=master)](http://travis-ci.org/jwage/easy-csv)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/jwage/easy-csv/badges/quality-score.png?s=2de4fb739a50630ffcbc61b62bfda161ac38afd4)](https://scrutinizer-ci.com/g/jwage/easy-csv/)
[![Code Coverage](https://scrutinizer-ci.com/g/jwage/easy-csv/badges/coverage.png?s=e77261403858e1bd97b4135a622e76a0423ec248)](https://scrutinizer-ci.com/g/jwage/easy-csv/)
[![Latest Stable Version](https://poser.pugx.org/jwage/easy-csv/v/stable.png)](https://packagist.org/packages/jwage/easy-csv)
[![Total Downloads](https://poser.pugx.org/jwage/easy-csv/downloads.png)](https://packagist.org/packages/jwage/easy-csv)
[![Dependency Status](https://www.versioneye.com/php/jwage:easy-csv/1.0.0/badge.png)](https://www.versioneye.com/php/jwage:easy-csv/1.0.0)


## Reader

To read CSV files we need to instantiate the EasyCSV reader class:

```php
$reader = new \EasyCSV\Reader('read.csv');
```

You can iterate over the rows one at a time:

```php
while ($row = $reader->getRow()) {
    print_r($row);
}
```

Or you can get everything all at once:

```php
print_r($reader->getAll());
```

## Writer

To write CSV files we need to instantiate the EasyCSV writer class:

```php
$writer = new \EasyCSV\Writer('write.csv');
```

You can write a row by passing a commas separated string:

```php
$writer->writeRow('column1, column2, column3');
```

Or you can pass an array:

```php
$writer->writeRow(array('column1', 'column2', 'column3'));
```

You can also write several rows at once:

```php
$writer->writeFromArray(array(
    'value1, value2, value3',
    array('value1', 'value2', 'value3')
));
```
