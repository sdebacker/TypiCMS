<?php

class BlockSeeder extends Seeder
{
    public function run()
    {
        $typi_blocks = array(
          array('id' => '1','name' => 'block1','created_at' => '2014-06-19 10:56:38','updated_at' => '2014-06-19 10:56:38')
        );

        $typi_block_translations = array(
          array('id' => '1','block_id' => '1','locale' => 'fr','status' => '1','body' => '<h3>Ceci est un bloc</h3>
        <p>Vous pouvez créer des blocs de contenu via l’interface d’administration et récupérer leur contenu : &lt;?php echo Blocks::build(\'name\'); ?&gt;.</p>','created_at' => '2014-06-19 10:56:38','updated_at' => '2014-06-19 10:56:38'),
          array('id' => '2','block_id' => '1','locale' => 'nl','status' => '1','body' => '<h3>This is a block</h3>
        <p>You can create blocks via admin interface and then call them via &lt;?php echo Blocks::build(\'name\'); ?&gt;.</p>','created_at' => '2014-06-19 10:56:38','updated_at' => '2014-06-19 10:56:38'),
          array('id' => '3','block_id' => '1','locale' => 'en','status' => '1','body' => '<h3>This is a block</h3>
        <p>You can create blocks via admin interface and then call them via &lt;?php echo Blocks::build(\'name\'); ?&gt;.</p>','created_at' => '2014-06-19 10:56:38','updated_at' => '2014-06-19 10:56:38')
        );

        DB::table('blocks')->insert( $typi_blocks );
        DB::table('block_translations')->insert( $typi_block_translations );

    }

}
