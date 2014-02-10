<?php namespace Way\Form;

use Form, Config, Session;

class FormField {

    /**
     * Instance
     *
     * @var Way\Form\FormField
     */
    protected static $instance;

    /**
     * Make the form field
     *
     * @param string $name
     * @param array $args
     */
    public function make($name, array $args)
    {
        $wrapper = $this->createWrapper($name);
        $field = $this->createField($name, $args);

        return str_replace('{{FIELD}}', $field, $wrapper);
    }

    /**
     * Prepare the wrapping container for
     * each field.
     */
    protected function createWrapper($name)
    {
        $wrapper = Config::get('form::wrapper');
        $wrapperClass = Config::get('form::wrapperClass');

        if ( $this->hasError($name) ) {
            $wrapperClass .= ' '.Config::get('form::errorClass');
        }

        return '<' . $wrapper . ' class="' . $wrapperClass . '">{{FIELD}}</' . $wrapper . '>';
    }

    /**
     * Create the form field
     *
     * @param string $name
     * @param array $args
     */
    protected function createField($name, $args)
    {
        // If the user specifies an input type, we'll just use that.
        // Otherwise, we'll take a best guess approach.
        $type = array_get($args, 'type') ?: $this->guessInputType($name);

        // We'll default to Bootstrap-friendly input class names
        $args = array_merge(['class' => Config::get('form::inputClass')], $args);

        $field = $this->createLabel($args, $name);

        unset($args['label']);
        
        $field .= $this->createInput($type, $args, $name);

        // create help-text block if error
        if ( $message = $this->hasError($name) ) {
            $field .= $this->createMessage($message);
        }
        
        return $field;
 
    }

    /**
     * Handle of creation of the label
     *
     * @param array $args
     * @param string $name
     */
    protected function createLabel($args, $name)
    {
        $label = array_get($args, 'label');

        // If no label was provided, let's do our best to construct
        // a label from the method name.
        is_null($label) and $label = $this->prettifyFieldName($name) . ': ';

        return $label ? Form::label($name, $label, array('class' => 'control-label')) : '';
    }

    /**
     * Handle of creation of the error message
     *
     * @param string $name
     */
    protected function createMessage($message)
    {
        return '<p class="help-block">' . $message . '</p>';
    }

    /**
     * Manage creation of input
     *
     * @param string $type
     * @param array $args
     * @param string $name
     */
    protected function createInput($type, $args, $name)
    {
        return $type == 'password'
            ? Form::password($name, $args)
            : Form::$type($name, null, $args);
    }

    /**
     * Provide a best guess for what the
     * input type should be.
     *
     * @param string $name
     */
    protected function guessInputType($name)
    {
        return array_get(Config::get('form::commonInputsLookup'), $name) ?: 'text';
    }

    /**
     * Clean up the field name for the label
     *
     * @param string $name
     */
    protected function prettifyFieldName($name)
    {
        return ucwords(preg_replace('/(?<=\w)(?=[A-Z])/', " $1", $name));
    }

    /**
     * Check if the field has errors
     *
     * @param  string $name
     * @return string
     */
    protected function hasError($name)
    {
        // replace opening brackets by dots and remove ending brackets
        $name = str_replace(array('[', ']'), array('.',''), $name);
        if ( Session::has('errors') ) {
            $errors = Session::get('errors');

            if ( $errors->has($name) )
                return $errors->first($name);
        }
        return '';
    }

    /**
     * Handle dynamic method calls
     *
     * @param string $name
     * @param array $args
     */
    public static function __callStatic($name, $args)
    {
        $args = empty($args) ? [] : $args[0];

        $instance = static::$instance;
        if ( ! $instance) $instance = static::$instance = new static;

        return $instance->make($name, $args);
    }

}
