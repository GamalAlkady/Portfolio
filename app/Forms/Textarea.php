<?php

// تأكد من تضمين Field.php قبل هذا الملف
require_once 'Field.php';

// دوال وهمية للوظائف الخارجية (تأكد من وجودها في مشروعك أو قم بتضمينها)
if (!function_exists('clear_textarea_breaks')) {
    function clear_textarea_breaks($text) {
        return str_replace(["\r\n", "\r", "\n"], '', $text);
    }
}
if (!function_exists('html_purify')) {
    function html_purify($html) {
        return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Class Textarea
 * Renders an HTML <textarea> element.
 */
class Textarea extends Field
{
    protected string $value = '';
    protected array $textarea_attrs = [];
    protected string $textarea_class = '';

    public function __construct(string $name, string $label = '', string $value = '')
    {
        parent::__construct($name, $label);
        $this->value = $value;
    }

    /**
     * Set the value for the textarea.
     * @param string $value
     * @return static
     */
    public function value(string $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set HTML attributes for the <textarea> tag.
     * @param array $attributes
     * @return static
     */
    public function attrs(array $attributes): static
    {
        $this->textarea_attrs = $attributes;
        return $this;
    }

    /**
     * Set additional CSS class for the <textarea> tag.
     * @param string $class
     * @return static
     */
    public function textareaClass(string $class): static
    {
        $this->textarea_class = $class;
        return $this;
    }

    /**
     * Render the HTML for the textarea field.
     * @return string
     */
    public function render(): string
    {
        if (!isset($this->textarea_attrs['rows'])) {
            $this->textarea_attrs['rows'] = 4;
        }

        $original_textarea_class = $this->textarea_class;
        if (isset($this->textarea_attrs['class'])) {
            $original_textarea_class .= ' ' . $this->textarea_attrs['class'];
            unset($this->textarea_attrs['class']);
        }

        $_textarea_attrs_str = $this->buildAttributes($this->textarea_attrs);
        $textarea_class_final = !empty($original_textarea_class) ? trim($original_textarea_class) : '';
        $textarea_class_final = !empty($textarea_class_final) ? ' ' . $textarea_class_final : '';

        $v = clear_textarea_breaks($this->value);
        if (strpos($textarea_class_final, 'tinymce') !== false) {
            $v = html_purify($this->value);
        }

        $textarea_html = '<textarea id="' . htmlspecialchars($this->name) . '" name="' . htmlspecialchars($this->name) . '" class="form-control' . htmlspecialchars($textarea_class_final) . '" ' . $_textarea_attrs_str . '>' . htmlspecialchars($this->value) . '</textarea>';

        // Handle required indicator in label
        $label_html = '';
        if ($this->label !== '') {
            $label_html .= '<label for="' . htmlspecialchars($this->name) . '" class="control-label">' . htmlspecialchars(_($this->label));
            if (isset($this->textarea_attrs['required']) && $this->textarea_attrs['required']) {
                $label_html .= '<span class="required text-danger" style="margin-left:5px">*</span>';
            }
            $label_html .= '</label>';
        }

        return $this->wrapInFormGroup($label_html . $textarea_html, false); // Pass false for $include_label
    }
}
