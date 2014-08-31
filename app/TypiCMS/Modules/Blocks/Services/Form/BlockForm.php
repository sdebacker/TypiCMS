<?php
namespace TypiCMS\Modules\Blocks\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Blocks\Repositories\BlockInterface;

class BlockForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, BlockInterface $block)
    {
        $this->validator = $validator;
        $this->repository = $block;
    }

    public function update(array $input)
    {
        $this->validator->setRule('name', 'required|unique:blocks,name,' . $input['id']);

        return parent::update($input);
    }
}
