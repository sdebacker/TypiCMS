<?php
$I = new WebGuy($scenario);
$I->wantTo('submit contact form');
$I->amOnPage('fr/contact');
$I->selectOption('Titre','M.');
$I->fillField('first_name','John');
$I->fillField('last_name','Doe');
$I->fillField('email','john@doe.com');
$I->fillField('message','Hello');
$I->click('Envoyer');
$I->amOnPage('fr/contact');
