<?php
$I = new TestGuy($scenario);
$I->wantTo('view user with email admin@example.com');
// $I->seeRecord('TypiCMS\Modules\Users\Models\User', array('email' => 'admin@example.com'));
$I->seeInDatabase('typi_users', array('email' => 'admin@example.com'));
