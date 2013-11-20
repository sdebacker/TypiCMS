<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| FR Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => "Le :attribute doit être accepted.",
	"active_url"       => "Le :attribute is not a valid URL.",
	"after"            => "Le :attribute doit être a date after :date.",
	"alpha"            => "Le :attribute may only contain letters.",
	"alpha_dash"       => "Le :attribute may only contain letters, numbers, et dashes.",
	"alpha_num"        => "Le :attribute may only contain letters et numbers.",
	"array"            => "Le :attribute doit être an array.",
	"before"           => "Le :attribute doit être a date before :date.",
	"between"          => array(
		"numeric" => "Le :attribute doit être entre :min - :max.",
		"file"    => "Le :attribute doit être entre :min - :max kilobytes.",
		"string"  => "Le :attribute doit être entre :min - :max characters.",
		"array"   => "Le :attribute must have entre :min - :max items.",
	),
	"confirmed"        => "Le :attribute confirmation does not match.",
	"date"             => "Le :attribute is not a valid date.",
	"date_format"      => "Le :attribute does not match the format :format.",
	"different"        => "Le :attribute et :other doit être different.",
	"digits"           => "Le :attribute doit être :digits digits.",
	"digits_between"   => "Le :attribute doit être entre :min et :max digits.",
	"email"            => "Le :attribute format is invalid.",
	"exists"           => "Le selected :attribute is invalid.",
	"image"            => "Le :attribute doit être an image.",
	"in"               => "Le selected :attribute is invalid.",
	"integer"          => "Le :attribute doit être an integer.",
	"ip"               => "Le :attribute doit être a valid IP address.",
	"max"              => array(
		"numeric" => ":attribute ne peut pas être plus grand que :max.",
		"file"    => ":attribute ne peut pas être plus grand que :max kilobytes.",
		"string"  => ":attribute ne peut pas être plus grand que :max caractères.",
		"array"   => ":attribute ne peut pas contenir plus de :max éléments.",
	),
	"mimes"            => ":attribute doit être un fichier du type : :values.",
	"min"              => array(
		"numeric" => ":attribute doit être au moins :min.",
		"file"    => ":attribute doit être au moins :min kilobytes.",
		"string"  => ":attribute doit être au moins :min caractères.",
		"array"   => ":attribute doit contenir au moins :min éléments.",
	),
	"not_in"           => ":attribute sélectionné n’est pas valide.",
	"numeric"          => ":attribute doit être un nombre.",
	"regex"            => ":attribute format n’est pas valide.",
	"required"         => "Le champ :attribute est requis.",
	"required_if"      => "Le champ :attribute est requis si :other est égal à :value.",
	"required_with"    => "Le champ :attribute est requis si :values est présent.",
	"required_without" => "Le champ :attribute est requis si :values n’est pas présent.",
	"same"             => ":attribute et :other doivent être égaux.",
	"size"             => array(
		"numeric" => ":attribute doit être :size.",
		"file"    => ":attribute doit être :size kilobytes.",
		"string"  => ":attribute doit être :size characters.",
		"array"   => ":attribute doit contenir :size éléments.",
	),
	"unique"           => "Le :attribute has already been taken.",
	"url"              => "Le :attribute format is invalid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		// General
		'title' => 'titre',
		'slug' => 'slug',
		'body' => 'corps',
		'meta_keywords' => 'meta mots clés',
		'meta_title' => 'meta titre',
		'meta_description' => 'meta description',
		'summary' => 'résumé',
		'uri' => 'URI',
		'website' => 'Site externe',
		'Online' => 'En ligne',

		// Pages
		'rss_enabled' => 'Activer un flux RSS',
		'comments_enabled' => 'Activer les commentaires',
		'is_home' => 'Définir en tant que page d’accueil',
		'css' => 'Code CSS',
		'js' => 'Code JavaScript',

		// Events
		'start_date' => 'Date de début',
		'end_date' => 'Date de fin',
		'start_time' => 'Heure de début',
		'end_time' => 'Heure de fin',
		'HH:MM' => 'HH:MM',
		'DDMMYYYY' => 'JJ.MM.AAAA',

		// Menulinks
		'page_id' => 'page',
		'menu_id' => 'menu',
		'module_name' => 'module',
		'target' => 'cible',
		'class' => 'class',
		'restricted_to' => 'restreint à',
		'link_type' => 'type de lien',

		// Users
		'first_name' => 'prénom',
		'last_name' => 'nom',
		'groups' => 'groupes',
		'email' => 'email',
		'password' => 'mot de passe',
		'password_confirmation' => 'Confirmer le mot de passe',
		'reset password' => 'réinitialiser le mot de passe',
		'register' => 's’enregistrer',
		'Change password (if not empty)' => 'Nouveau mot de passe',
		'save' => 'enregistrer',
		'log in' => 's’enregistrer',

		// Settings
		'webmasterEmail' => 'Email du webmaster',
		'typekitCode' => 'Code Typekit',
		'googleAnalyticsUniversalCode' => 'Google Analytics Universal',
		'googleAnalyticsCode' => 'Google Analytics Classic',
		'langChooser' => 'Page de choix de langue',

		'Submit' => 'Envoyer',
		'Reset' => 'Reinitialiser',
		'Cancel' => 'Annuler',
	),

	// Values, for example for select menus
	'values' => array(
		'Active tab' => 'Onglet actif',
		'New tab' => 'Nouvel onglet',
	),

);
