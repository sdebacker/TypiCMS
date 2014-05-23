<?php

class TranslationSeeder extends Seeder
{
    public function run()
    {

        $typi_translations = array(
            array('id'=>1, 'group'=>'db', 'key'=>'More', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>2, 'group'=>'db', 'key'=>'Skip to content', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>3, 'group'=>'db', 'key'=>'languages.fr', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>4, 'group'=>'db', 'key'=>'languages.en', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>5, 'group'=>'db', 'key'=>'languages.nl', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>6, 'group'=>'db', 'key'=>'Search', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('id'=>7, 'group'=>'db', 'key'=>'message when contact form is sent', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
            array('id'=>8, 'group'=>'db', 'key'=>'message when errors in form', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
        );

        $typi_translation_translations = array(
            array('translation_id'=>1, 'locale'=>'fr', 'translation'=>'En savoir plus', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>1, 'locale'=>'en', 'translation'=>'More', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>1, 'locale'=>'nl', 'translation'=>'Meer', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>2, 'locale'=>'fr', 'translation'=>'Aller au contenu', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>2, 'locale'=>'en', 'translation'=>'Skip to content', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>2, 'locale'=>'nl', 'translation'=>'Naar inhoud', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>3, 'locale'=>'fr', 'translation'=>'Français', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>3, 'locale'=>'en', 'translation'=>'Français', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>3, 'locale'=>'nl', 'translation'=>'Français', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>4, 'locale'=>'fr', 'translation'=>'English', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>4, 'locale'=>'en', 'translation'=>'English', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>4, 'locale'=>'nl', 'translation'=>'English', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>5, 'locale'=>'fr', 'translation'=>'Nederlands', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>5, 'locale'=>'en', 'translation'=>'Nederlands', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>5, 'locale'=>'nl', 'translation'=>'Nederlands', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>6, 'locale'=>'fr', 'translation'=>'Chercher', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>6, 'locale'=>'en', 'translation'=>'Search', 'created_at'=>'2014-02-28 22:50:19', 'updated_at'=>'2014-02-28 22:50:19'),
            array('translation_id'=>6, 'locale'=>'nl', 'translation'=>'Zoeken', 'created_at'=>'2014-02-28 22:50:51', 'updated_at'=>'2014-02-28 22:50:51'),
            array('translation_id'=>7, 'locale'=>'fr', 'translation'=>'Merci', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
            array('translation_id'=>7, 'locale'=>'en', 'translation'=>'Thank you', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
            array('translation_id'=>7, 'locale'=>'nl', 'translation'=>'Dank u', 'created_at'=>'2014-05-17 22:50:51', 'updated_at'=>'2014-05-17 22:50:51'),
            array('translation_id'=>8, 'locale'=>'fr', 'translation'=>'Veuillez s’il vous plaît corriger les erreurs ci-dessous', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
            array('translation_id'=>8, 'locale'=>'en', 'translation'=>'Please correct the errors below', 'created_at'=>'2014-05-17 22:50:19', 'updated_at'=>'2014-05-17 22:50:19'),
            array('translation_id'=>8, 'locale'=>'nl', 'translation'=>'Gelieve de onderstaande fouten te corrigeren', 'created_at'=>'2014-05-17 22:50:51', 'updated_at'=>'2014-05-17 22:50:51'),
        );

        DB::table('translations')->insert( $typi_translations );
        DB::table('translation_translations')->insert( $typi_translation_translations );

    }

}
