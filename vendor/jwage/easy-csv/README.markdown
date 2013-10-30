EasyCSV
=======

EasyCSV is a simple Object Oriented CSV manipulation library for PHP 5.3+

[![Build Status](https://secure.travis-ci.org/jwage/EasyCSV.png?branch=master)](http://travis-ci.org/jwage/EasyCSV)

## Reader

To read CSV files we need to instantiate the EasyCSV reader class:

```php
<?php
$reader = new \EasyCSV\Reader('read.csv');
```

You can iterate over the rows one at a time:

```php
<?php
while ($row = $reader->getRow()) {
    print_r($row);
}
```

Or you can get everything all at once:

```php
<?php
print_r($reader->getAll());
```

## Writer

To write CSV files we need to instantiate the EasyCSV writer class:

```php
<?php
$writer = new \EasyCSV\Writer('write.csv');
```

You can write a row by passing a commas separated string:

```php
<?php
$writer->writeRow('column1, column2, column3');
```

Or you can pass an array:

```php
<?php
$writer->writeRow(array('column1', 'column2', 'column3'));
```

You can also write several rows at once:

```php
<?php
$writer->writeFromArray(array(
    'value1, value2, value3',
    array('value1', 'value2', 'value3')
));
```
