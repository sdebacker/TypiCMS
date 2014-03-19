<?php
$I = new WebGuy($scenario);
$I->wantTo('register with existing email');
$I->amOnPage('users/register');
$I->fillField('email','admin@example.com');
$I->fillField('first_name','Samuel');
$I->fillField('last_name','De Backer');
$I->fillField('password','trucmuche');
$I->fillField('password_confirmation','trucmuche');
$I->click('Register');
$I->amOnPage('users/register');
