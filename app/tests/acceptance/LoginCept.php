<?php
$I = new WebGuy($scenario);
$I->wantTo('log in');
$I->amOnPage('users/login');
$I->fillField('email','admin@example.com');
$I->fillField('password','admin');
$I->click('button[type=submit]');
$I->dontSeeInCurrentUrl('users/login');
