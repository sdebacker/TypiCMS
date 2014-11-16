<?php
namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Traits\Historable;

abstract class BaseTranslation extends Model
{

    use Historable;

    protected $touches = ['owner'];
}
