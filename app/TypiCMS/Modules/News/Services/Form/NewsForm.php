<?php
namespace TypiCMS\Modules\News\Services\Form;

use Input;
use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;

class NewsForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, NewsInterface $news)
    {
        $this->validator = $validator;
        $this->repository = $news;
    }

    /**
     * Update an existing item
     * 
     * @param  array  $input
     * @return boolean
     */
    public function update(array $input)
    {
        // add relations data (default to empty array)
        $input['galleries'] = Input::get('galleries', []);

        return parent::update($input);
    }
}
