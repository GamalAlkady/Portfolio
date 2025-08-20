<?php

// تأكد من تضمين جميع الكلاسات والدوال المساعدة
//require_once 'Toaster.php'; // إذا كنت تستخدم الـ Enum
require_once 'Field.php';
require_once 'Input.php';
require_once 'Textarea.php';
require_once 'Select.php';

// دوال وهمية للوظائف الخارجية (تحتاج إلى تطبيقها فعليًا في مشروعك)
// هذه الدوال ضرورية لكي تعمل الكلاسات بشكل صحيح.
if (!function_exists('clear_success')) {
    function clear_success() {
        // echo "<!-- Success message cleared -->";
    }
}
if (!function_exists('clear_error')) {
    function clear_error() {
        // echo "<!-- Error message cleared -->";
    }
}
// _(), clear_textarea_breaks(), html_purify() are assumed to be included by Field.php or elsewhere.

/**
 * Class Form
 * A factory and builder for rendering various HTML form elements.
 */
class Form
{
    private string $element_type = '';
    private array $element_data = [];
    private string $form_group_class = '';

//    /**
//     * Renders an alert message.
//     * @param string|array $text The message text or an array of messages.
//     * @param string $class The Bootstrap alert class (e.g., 'alert-success', 'alert-danger').
//     * @return Form
//     */
//    public function alert($text, string $class = 'alert-danger'): self
//    {
//        $this->element_type = 'alert';
//        $this->element_data = ['text' => $text, 'class' => $class];
//        return $this;
//    }
//
//    /**
//     * Renders a Toaster notification.
//     * Requires Toastr.js to be included in your project.
//     * @param string $text The message text.
//     * @param Toaster $toaster The type of toaster (SUCCESS, ERROR, INFO).
//     * @return Form
//     */
//    public function toaster(string $text = "", Toaster $toaster = Toaster::SUCCESS): self
//    {
//        $this->element_type = 'toaster';
//        $this->element_data = ['text' => $text, 'type' => $toaster];
//        return $this;
//    }

    /**
     * Set additional CSS class for the form group wrapper div.
     * @param string $class
     * @return static
     */
    public function formGroupClass(string $class): self
    {
        $this->form_group_class = $class;
        return $this;
    }

    /**
     * Renders a button, optionally wrapped in a form.
     * @param array $attr HTML attributes for the button (e.g., ['class' => 'btn btn-primary', 'id' => 'myBtn']).
     * @param string $text The button text.
     * @param string $icon HTML for the icon (e.g., '<i class="fas fa-plus"></i>').
     * @param string $class_group CSS class for the button's wrapper div.
     * @param string $style_group Inline style for the button's wrapper div.
     * @param string $action The form action URL if the button is part of a form.
     * @param string $method The form method ('post' or 'get').
     * @param string $elements Additional HTML elements to include inside the form before the button.
     * @return Form
     */
    public function button(array $attr, string $text, string $icon, string $class_group = '', string $style_group = '', string $action = '', string $method = 'post', string $elements = ''): self
    {
        $this->element_type = 'button';
        $this->element_data = compact('attr', 'text', 'icon', 'class_group', 'style_group', 'action', 'method', 'elements');
        return $this;
    }

    /**
     * Renders a group of checkboxes.
     * @param array $attr HTML attributes for each input checkbox (e.g., ['class' => 'form-check-input']).
     * @param array $items An associative array of checkbox items (key => label).
     * @param array $checked_values An array of keys for checked checkboxes.
     * @param string $attr_group HTML attributes for the wrapper div of each checkbox.
     * @return Form
     */
    public function checkbox(array $attr, array $items, array $checked_values = [], string $attr_group = ''): self
    {
        $this->element_type = 'checkbox';
        $this->element_data = compact('attr', 'items', 'checked_values', 'attr_group');
        return $this;
    }

    /**
     * Renders a Yes/No radio button option.
     * @param string $name The name attribute for the radio buttons.
     * @param string $label The label for the option.
     * @param string $tooltip Tooltip text for the label.
     * @param bool $required Whether the field is required.
     * @param string $replace_yes_text Custom text for the 'Yes' option.
     * @param string $replace_no_text Custom text for the 'No' option.
     * @param string $checkedValue The currently checked value (e.g., '1' for Yes, '0' for No).
     * @param string $replace_1 Custom value for the 'Yes' option (defaults to 1).
     * @param string $replace_0 Custom value for the 'No' option (defaults to 0).
     * @return Form
     */
    public function yesNoOption(string $name, string $label, string $tooltip = '', bool $required = false, string $replace_yes_text = '', string $replace_no_text = '', string $checkedValue = '', string $replace_1 = '', string $replace_0 = ''): self
    {
        $this->element_type = 'yes_no_option';
        $this->element_data = compact('name', 'label', 'tooltip', 'required', 'replace_yes_text', 'replace_no_text', 'checkedValue', 'replace_1', 'replace_0');
        return $this;
    }

    /**
     * Creates and returns an Input object for a standard input field.
     * @param string $name The name attribute for the input.
     * @param string $label The label for the input.
     * @param string $value The default value of the input.
     * @param string $type The input type (e.g., 'text', 'number', 'email').
     * @return Input
     */
    public function input(string $name, string $label = '', string $value = '', string $type = 'text'): Input
    {
        return (new Input($name, $label, $value, $type))
            ->formGroupClass($this->form_group_class);
    }

    /**
     * Creates and returns an Input object configured for a file input field.
     * @param string $name The name attribute for the input.
     * @param string $label The label for the input.
     * @param string $value The default value (e.g., filename) of the input.
     * @return Input
     */
    public function fileInput(string $name, string $label = '', string $value = ''): Input
    {
        return (new Input($name, $label, $value, 'file'))
            ->attrs(['accept' => 'image/*']); // Example default for file input
    }

    /**
     * Creates and returns an Input object configured for a color picker input.
     * @param string $name The name attribute for the input.
     * @param string $label The label for the input.
     * @param string $value The default color value.
     * @return Input
     */
    public function colorPicker(string $name, string $label = '', string $value = ''): Input
    {
        return (new Input($name, $label, $value, 'color'))
            ->class('colorpicker-input'); // Add class for color picker JS
    }

    /**
     * Creates and returns an Input object configured for a date picker input.
     * @param string $name The name attribute for the input.
     * @param string $label The label for the input.
     * @param string $value The default date value.
     * @return Input
     */
    public function dateInput(string $name, string $label = '', string $value = ''): Input
    {
        return (new Input($name, $label, $value, 'date'))
            ->class('datepicker') // Add class for date picker JS
            ->attrs(['autocomplete' => 'off']);
    }

    /**
     * Creates and returns an Input object configured for a datetime picker input.
     * @param string $name The name attribute for the input.
     * @param string $label The label for the input.
     * @param string $value The default datetime value.
     * @return Input
     */
    public function datetimeInput(string $name, string $label = '', string $value = ''): Input
    {
        return (new Input($name, $label, $value, 'datetime-local')) // Using datetime-local for consistency
        ->class('datetimepicker') // Add class for datetime picker JS
        ->attrs(['autocomplete' => 'off']);
    }


    /**
     * Creates and returns a Textarea object.
     * @param string $name The name attribute for the textarea.
     * @param string $label The label for the textarea.
     * @param string $value The default value of the textarea.
     * @return Textarea
     */
    public function textarea(string $name, string $label = '', string $value = ''): Textarea
    {
        return (new Textarea($name, $label, $value))->formGroupClass($this->form_group_class);
    }

    /**
     * Creates and returns a Select object.
     * @param string $name The name attribute for the select.
     * @param array $options An array of options for the select.
     * @param array $option_attrs An array specifying the keys for option value, text, and optional subtext.
     * @param string $label The label for the select.
     * @return Select
     */
    public function select(string $name, array $options, array $option_attrs = [], string $label = ''): Select
    {
        return (new Select($name, $options, $option_attrs, $label))->formGroupClass($this->form_group_class);
    }

    /**
     * Renders a select field specifically for estimate request statuses.
     * This method directly renders the select as it's a specific use-case.
     * @param array $statuses An array of status objects/arrays, each with 'id' and 'name' keys, and optionally 'flag'.
     * @param string $selected The ID of the selected status.
     * @param string $lang_key The language key for the select label.
     * @param string $name The name attribute for the select (defaults to 'status').
     * @param array $select_attrs HTML attributes for the <select> tag.
     * @return Form
     */
    public function estimateRequestStatusSelect(array $statuses, string $selected = '', string $lang_key = '', string $name = 'status', array $select_attrs = []): self
    {
        $this->element_type = 'estimate_request_status_select';
        $this->element_data = compact('statuses', 'selected', 'lang_key', 'name', 'select_attrs');
        return $this;
    }

    /**
     * Sets the element type to open a form tag.
     * @param array $attributes HTML attributes for the <form> tag (e.g., ['action' => 'submit.php', 'method' => 'post']).
     * @return Form
     */
    public function openForm(array $attributes = []): self
    {
        $this->element_type = 'form_open';
        $this->element_data = ['attributes' => $attributes];
        return $this;
    }

    /**
     * Sets the element type to close a form tag.
     * @return Form
     */
    public function closeForm(): self
    {
        $this->element_type = 'form_close';
        $this->element_data = []; // No specific data needed for closing tag
        return $this;
    }

    /**
     * Renders the constructed HTML form element.
     * @return string The HTML string of the rendered element.
     */
    public function render(): string
    {
        $html = '';
        extract($this->element_data); // Extract all element data into local variables

        switch ($this->element_type) {
            case 'alert':
                if (is_array($text)) {
                    foreach ($text as $txt) {
                        $html .= '<div class="alert mb-2 ' . htmlspecialchars($class) . '" role="alert">' . htmlspecialchars($txt) . '</div>';
                    }
                } else {
                    $html .= '<div class="alert mb-2 ' . htmlspecialchars($class) . '" role="alert">' . htmlspecialchars($text) . '</div>';
                }
                break;

            case 'button':
                $_attrs = '';
                foreach ($attr as $key => $val) {
                    if ($key == 'title') {
                        $val = _($val); // Assuming _() is for translation
                    }
                    $_attrs .= htmlspecialchars($key) . '="' . htmlspecialchars($val) . '" ';
                }
                $btn_html = '<div class="' . htmlspecialchars($class_group) . '" style="' . htmlspecialchars($style_group) . '">';
                $btn_html .= "<button  $_attrs>";
                $btn_html .= $icon; // Icon HTML is assumed to be safe
                $btn_html .= htmlspecialchars($text);
                $btn_html .= '</button>';
                $btn_html .= '</div>';

                if (!empty($action)) {
                    $form_attr = "action=\"" . htmlspecialchars($action) . "\" method=\"" . htmlspecialchars($method) . "\"";
                    $form_html = "<form $form_attr >" . $elements . $btn_html . "</form>"; // $elements assumed safe
                    $html = $form_html;
                } else {
                    $html = $btn_html;
                }
                break;

            case 'checkbox':
                foreach ($items as $key => $item) {
                    $checked = (is_array($checked_values) && in_array($key, $checked_values)) ? 'checked' : "";
                    $html .= '<fieldset>';
                    $html .= "<div " . htmlspecialchars($attr_group) . " >";
                    // Using $key for label's 'for' attribute and input's 'id' for better accessibility
                    $html .= '<label for="' . htmlspecialchars($key) . '">' . htmlspecialchars($item) . '</label>';
                    $_input_attrs = '';
                    foreach ($attr as $input_attr_key => $input_attr_val) {
                        $_input_attrs .= htmlspecialchars($input_attr_key) . '="' . htmlspecialchars($input_attr_val) . '" ';
                    }
                    $html .= '<input type="checkbox" ' . $_input_attrs . ' value="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '" ' . $checked . '>';
                    $html .= '</div>';
                    $html .= '<div class="dropdown-divider"></div>';
                    $html .= '</fieldset>';
                }
                break;

            case 'yes_no_option':
                ob_start();
                $replace_1_val = $replace_1 == '' ? 1 : $replace_1;
                $replace_0_val = $replace_0 == '' ? 0 : $replace_0;
                ?>
                <div class="form-group col-md-3 mb-2">
                    <label for="<?php echo htmlspecialchars($name); ?>" class="control-label clearfix">
                        <?php echo ($tooltip != '' ? '<i class="fa fa-question-circle" data-toggle="tooltip" data-title="' . htmlspecialchars(_($tooltip)) . '"></i> ' : '') . htmlspecialchars(_($label)); ?>
                        <?php if ($required) echo '<span class="required d-inline-block">*</span>' ?>
                    </label>
                    <div class="controls mt-1">
                        <div class="custom-control custom-radio d-inline-block col-6">
                            <input type="radio" id="y_opt_1_<?php echo htmlspecialchars($name); ?>" name="<?php echo htmlspecialchars($name); ?>"
                                   value="<?php echo htmlspecialchars($replace_1_val); ?>"
                                <?php if ($checkedValue == $replace_1_val) {
                                    echo 'checked ';
                                }
                                if ($required) echo 'required '; ?> class="custom-control-input">
                            <label for="y_opt_1_<?php echo htmlspecialchars($name); ?>" class="custom-control-label">
                                <?php echo htmlspecialchars($replace_yes_text == '' ? _('settings_yes') : _($replace_yes_text)); ?>
                            </label>
                        </div>
                        <div class="custom-control custom-radio d-inline-block">
                            <input type="radio" id="y_opt_2_<?php echo htmlspecialchars($name); ?>" name="<?php echo htmlspecialchars($name); ?>"
                                   value="<?php echo htmlspecialchars($replace_0_val); ?>"
                                <?php if ($checkedValue == $replace_0_val) {
                                    echo 'checked ';
                                }
                                if ($required) echo 'required '; ?> class="custom-control-input">
                            <label for="y_opt_2_<?php echo htmlspecialchars($name); ?>" class="custom-control-label">
                                <?php echo htmlspecialchars($replace_no_text == '' ? _('settings_no') : _($replace_no_text)); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                $html = ob_get_clean();
                break;

            case 'estimate_request_status_select':
                if ($selected == '') {
                    foreach ($statuses as $status) {
                        if (isset($status['flag']) && $status['flag'] == 'processing') {
                            $selected = $status['id'];
                            break;
                        }
                    }
                }
                // Use the new Select class
                $select_field = (new Select($name, $statuses, ['id', 'name'], $lang_key))
                    ->selected($selected)
                    ->attrs($select_attrs);
                $html = $select_field->render();
                break;

            case 'form_open':
                $_attrs = '';
                foreach ($attributes as $key => $val) {
                    $_attrs .= htmlspecialchars($key) . '="' . htmlspecialchars($val) . '" ';
                }
                $html = '<form ' . rtrim($_attrs) . '>';
                break;

            case 'form_close':
                $html = '</form>';
                break;

            default:
                $html = '';
                // You might want to throw an exception or log an error for unknown element types
                break;
        }
        return $html;
    }
}
