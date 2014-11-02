<?php
namespace TypiCMS\Modules\Translations\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentTranslation extends RepositoriesAbstract implements TranslationInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get translations to Array
     *
     * @return array
     */
    public function getAllToArray($locale, $group, $namespace = null)
    {
        $array = $this->model
                ->join('translation_translations', 'translations.id', '=', 'translation_translations.translation_id')
                ->where('locale', $locale)
                ->where('group', $group)
                ->lists('translation', 'key');

        return $array;
    }
}
