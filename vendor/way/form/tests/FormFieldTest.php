<?php

class FormFieldTest extends TestCase {

    public function test_prepares_form_field()
    {
        $html = FormField::username();

        $this->assertContains('<div class="form-group">', $html);
        $this->assertContains('<label for="username" class="control-label">Username: </label>', $html);
        $this->assertContains('<input class="form-control" name="username" type="text" id="username">', $html);
    }

    public function test_allows_input_type_to_be_overridden()
    {
        $html = FormField::someField(['type' => 'textarea']);

        $this->assertContains(
            '<textarea class="form-control" type="textarea" name="someField" cols="50" rows="10" id="someField">',
            $html
        );
    }

    public function test_can_set_custom_label_text()
    {
        $html = FormField::someField(['label' => 'Some Amazing Field']);

        $this->assertContains('label for="someField" class="control-label">Some Amazing Field</label>', $html);
    }

    public function test_label_can_be_set_to_null()
    {
        $html = FormField::someField(['label' => false]);

        $this->assertNotContains('label', $html);
    }

    public function test_recognizes_basic_input_names_and_sets_input_type()
    {
        $html = FormField::email();

        $this->assertContains('type="email"', $html);
    }
}
