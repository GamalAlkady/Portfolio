<?php

// دوال وهمية للوظائف الخارجية (تأكد من وجودها في مشروعك أو قم بتضمينها)
// هذه الدوال ضرورية لكي تعمل الكلاسات بشكل صحيح.
//if (!function_exists('_')) {
//    function _($key) {
//        // قم بتطبيق منطق الترجمة هنا
//        $translations = [
//            'settings_yes' => 'نعم',
//            'settings_no' => 'لا',
//            'dropdown_non_selected_tex' => 'يرجى الاختيار',
//            // أضف المزيد من الترجمات هنا
//        ];
//        return $translations[$key] ?? $key;
//    }
//}

/**
 * Abstract Class Field
 * Provides common properties and methods for all form elements.
 */
abstract class Field
{
    protected string $name = '';
    protected string $label = '';
    protected string $placeHolder = '';
    protected array $form_group_attr = [];
    protected string $form_group_class = '';

    public function __construct(string $name, string $label = '',$placeHolder='')
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeHolder = $placeHolder;
    }

    /**
     * Set the name attribute for the field.
     * @param string $name
     * @return static
     */
    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the label for the field.
     * @param string $label
     * @return static
     */
    public function label(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set the label for the field.
     * @param string $label
     * @return static
     */
    public function placeHolder(string $placeHolder): static
    {
        $this->placeHolder = $placeHolder;
        return $this;
    }

    /**
     * Set HTML attributes for the form group wrapper div.
     * @param array $attributes
     * @return static
     */
    public function formGroupAttrs(array $attributes): static
    {
        $this->form_group_attr = $attributes;
        return $this;
    }

    /**
     * Set additional CSS class for the form group wrapper div.
     * @param string $class
     * @return static
     */
    public function formGroupClass(string $class): static
    {
        $this->form_group_class = $class;
        return $this;
    }

    /**
     * Render the HTML for the field.
     * @return string
     */
    abstract public function render(): string;

    /**
     * Helper to convert an associative array of attributes to an HTML string.
     * @param array $attributes
     * @return string
     */
    protected function buildAttributes(array $attributes): string
    {
        $_attrs = '';
        foreach ($attributes as $key => $val) {
            if ($key === 'title') {
                $val = _($val); // Apply translation for title attribute
            }
            $_attrs .= htmlspecialchars($key) . '="' . htmlspecialchars($val) . '" ';
        }
        return rtrim($_attrs);
    }

    /**
     * Generate the form group wrapper HTML.
     * @param string $content The HTML content of the field itself.
     * @param bool $include_label Whether to include the label.
     * @return string
     */
    protected function wrapInFormGroup(string $content, bool $include_label = true): string
    {
        $_form_group_attr = $this->form_group_attr;
        $_form_group_attr['app-field-wrapper'] = $this->name; // Add default wrapper attribute

        $form_group_attrs_str = $this->buildAttributes($_form_group_attr);
        $form_group_class_final = !empty($this->form_group_class) ? ' ' . $this->form_group_class : '';

        $html = '<div class="form-group' . htmlspecialchars($form_group_class_final) . '" ' . $form_group_attrs_str . '>';
        if ($include_label && $this->label !== '') {
            $html .= '<label for="' . htmlspecialchars($this->name) . '" class="control-label">' . htmlspecialchars(_($this->label));
            // Check for 'required' attribute in input_attrs (if applicable to the child class)
            // This needs to be handled by child classes as they hold input_attrs
            $html .= '</label>';
        }
        $html .= $content;

        $html .='<div class="form-error text-danger text-sm mt-1">'.errors($this->name).'</div>';

$html .= '</div>';

        return $html;
    }
}
