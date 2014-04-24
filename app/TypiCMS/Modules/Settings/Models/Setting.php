<?php
namespace TypiCMS\Modules\Settings\Models;

use Eloquent;

class Setting extends Eloquent
{

    protected $fillable = array(
        'package',
        'group_name',
        'key_name',
        'value',
        'type',
        'environment',
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';
}
