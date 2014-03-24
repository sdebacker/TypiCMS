<?php
$I = new WebGuy($scenario);
$I->wantTo('update a page');
$I->amOnPage('users/login');
$I->fillField('email','admin@example.com');
$I->fillField('password','admin');
$I->click('button[type=submit]');

$I->amOnPage('/admin/pages/1/edit');
$I->fillField('fr[title]','title test');
$I->click('Save and exit');
$I->seeCurrentUrlEquals('/admin/pages');

