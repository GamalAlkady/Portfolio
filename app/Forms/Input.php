<?php

// تأكد من تضمين Field.php قبل هذا الملف
require_once 'Field.php';

/**
 * Class Input
 * Renders an HTML <input> element.
 */
class Input extends Field
{
    protected string $value = '';
    protected string $type = 'text';
    protected array $input_attrs = [];
    protected string $input_class = '';
    protected string $controls_class = ''; // For the div.controls wrapper

    public function __construct(string $name, string $label = '', string $value = '', string $type = 'text')
    {
        parent::__construct($name, $label);
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Set the value attribute for the input.
     * @param string $value
     * @return static
     */
    public function value(string $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set the type attribute for the input (e.g., 'text', 'number', 'email', 'file', 'date', 'color').
     * @param string $type
     * @return static
     */
    public function type(string $type='text'): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set HTML attributes for the <input> tag.
     * @param array $attributes
     * @return static
     */
    public function attrs(array $attributes): static
    {
        $this->input_attrs = $attributes;
        return $this;
    }

    /**
     * Set additional CSS class for the <input> tag.
     * @param string $class
     * @return static
     */
    public function class(string $class): static
    {
        $this->input_class = $class;
        return $this;
    }

    /**
     * Set additional CSS class for the controls div (wrapper around the input).
     * @param string $class
     * @return static
     */
    public function controlsClass(string $class): static
    {
        $this->controls_class = $class;
        return $this;
    }

    /**
     * Render the HTML for the input field.
     * @return string
     */
    public function render(): string
    {
        $_input_attrs_str = $this->buildAttributes($this->input_attrs);
        $input_class_final = !empty($this->input_class) ? ' ' . $this->input_class : '';
        $controls_class_final = !empty($this->controls_class) ? ' ' . $this->controls_class : '';
        $this->placeHolder=(!empty($this->placeHolder)?$this->placeHolder:$this->label);
        $input_html = '';
        if ($this->type === 'file') {
            $input_html .= '<div class="custom-file">';
            $input_html .= '<input type="' . htmlspecialchars($this->type) . '" id="' . htmlspecialchars($this->name) . '" name="' . htmlspecialchars($this->name) . '" class="form-control' . htmlspecialchars($input_class_final) . '" ' . $_input_attrs_str . ' value="' . htmlspecialchars($this->value) . '"' . 'placeholder="' . htmlspecialchars(_($this->placeHolder)) . '">';
            $input_html .= '<label class="custom-file-label" for="' . htmlspecialchars($this->name) . '">' . htmlspecialchars($this->placeHolder) . '</label>';
            $input_html .= '</div>';
        } elseif ($this->type === 'date' || $this->type === 'datetime-local') { // Using datetime-local for datetimepicker
            $picker_class = ($this->type === 'date' ? 'datepicker' : 'datetimepicker');
            $input_html .= '<div class="input-group date">';
            $input_html .= '<input type="text" id="' . htmlspecialchars($this->name) . '" name="' . htmlspecialchars($this->name) . '" class="form-control ' . htmlspecialchars($picker_class) . htmlspecialchars($input_class_final) . '" ' . $_input_attrs_str . ' value="' . htmlspecialchars($this->value) . '" autocomplete="off">';
            $input_html .= '<div class="input-group-addon">
                <i class="fa fa-calendar calendar-icon"></i>
            </div>';
            $input_html .= '</div>';
        } elseif ($this->type === 'color') {
            $input_html .= '<div class="input-group mbot15 colorpicker-input">
                <input type="text" value="' . htmlspecialchars($this->value) . '" name="' . htmlspecialchars($this->name) . '" id="' . htmlspecialchars($this->name) . '" class="form-control" ' . $_input_attrs_str . ' />
                <span class="input-group-addon"><i></i></span>
            </div>';
        } else {
            $input_html .= '<div class="controls' . htmlspecialchars($controls_class_final) . '">';
            $input_html .= '<input type="' . htmlspecialchars($this->type) . '" id="' . htmlspecialchars($this->name) . '" name="' . htmlspecialchars($this->name) . '" class="form-control' . htmlspecialchars($input_class_final) . '" ' . $_input_attrs_str . ' value="' . htmlspecialchars($this->value) . '"' . 'placeholder="' . htmlspecialchars(_(ucfirst($this->placeHolder))) . '">';
            $input_html .= '</div>';
        }

        // Handle required indicator in label
        $label_html = '';
        if ($this->label !== '') {
            $label_class=$this->label_class??'control-label';
            $label_html .= '<label for="' . htmlspecialchars($this->name) . '" class="'.$label_class.'">' . htmlspecialchars(_($this->label));
            if (isset($this->input_attrs['required']) && $this->input_attrs['required']) {
                $label_html .= '<span class="required text-danger" style="margin-left:5px">*</span>';
            }
            $label_html .= '</label>';
        }

        return $this->wrapInFormGroup($label_html . $input_html, false); // Pass false for $include_label as we build it here
    }
}
