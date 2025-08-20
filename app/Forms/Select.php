<?php

// تأكد من تضمين Field.php قبل هذا الملف
require_once 'Field.php';

/**
 * Class Select
 * Renders an HTML <select> element.
 */
class Select extends Field
{
    protected array $options = [];
    protected array $option_attrs = []; // Keys for value, text, subtext
    protected string|array $selected = '';
    protected string $select_class = '';
    protected bool $include_blank = true;
    protected ?string $input_group_contents = null; // For selectWithInputGroup

    /**
     * Constructor for the Select field.
     * Automatically formats simple string arrays into associative arrays for options.
     *
     * @param string $name The name attribute for the select.
     * @param array $options An array of options for the select (can be simple strings or associative arrays).
     * @param array $option_attrs An array specifying the keys for option value, text, and optional subtext (e.g., ['id', 'name', 'description']).
     * If $options is a simple string array, this can be omitted or set to ['id', 'name'].
     * @param string $label The label for the select.
     */
    public function __construct(string $name, array $options, array $option_attrs = [], string $label = '')
    {
        parent::__construct($name, $label);

        // Check if the options array is a simple array of strings
        if (!empty($options) && is_string(reset($options))) {
            $formatted_options = [];
            foreach ($options as $option_value) {
                $formatted_options[] = [
                    'id' => $option_value,
                    'name' => $option_value
                ];
            }
            $this->options = $formatted_options;
            // If option_attrs was not provided, default it for simple string arrays
            if (empty($option_attrs)) {
                $this->option_attrs = ['id', 'name'];
            } else {
                $this->option_attrs = $option_attrs;
            }
        } else {
            // It's already an associative array or empty
            $this->options = $options;
            $this->option_attrs = $option_attrs;
        }
    }

    /**
     * Set the options for the select field.
     * @param array $options
     * @return static
     */
    public function options(array $options): static
    {
        // Re-apply the formatting logic if options are set after construction
        if (!empty($options) && is_string(reset($options))) {
            $formatted_options = [];
            foreach ($options as $option_value) {
                $formatted_options[] = [
                    'id' => $option_value,
                    'name' => $option_value
                ];
            }
            $this->options = $formatted_options;
            // Ensure option_attrs are set correctly if not already
            if (empty($this->option_attrs)) {
                $this->option_attrs = ['id', 'name'];
            }
        } else {
            $this->options = $options;
        }
        return $this;
    }

    /**
     * Set the keys for option value, text, and optional subtext (e.g., ['id', 'name', 'description']).
     * @param array $option_attrs
     * @return static
     */
    public function optionAttrs(array $option_attrs): static
    {
        $this->option_attrs = $option_attrs;
        return $this;
    }

    /**
     * Set the selected value(s).
     * @param string|array $selected
     * @return static
     */
    public function selected(string|array $selected): static
    {
        $this->selected = $selected;
        return $this;
    }

    /**
     * Set additional CSS class for the <select> tag.
     * @param string $class
     * @return static
     */
    public function selectClass(string $class): static
    {
        $this->select_class = $class;
        return $this;
    }

    /**
     * Set whether to include a blank option.
     * @param bool $include_blank
     * @return static
     */
    public function includeBlank(bool $include_blank): static
    {
        $this->include_blank = $include_blank;
        return $this;
    }

    /**
     * Add content for an input group addon.
     * @param string $contents HTML content for the addon.
     * @return static
     */
    public function withInputGroup(string $contents): static
    {
        $this->input_group_contents = $contents;
        $this->select_class .= ' _select_input_group'; // Add specific class for styling
        return $this;
    }

    /**
     * Render the HTML for the select field.
     * @return string
     */
    public function render(): string
    {
        $callback_translate = '';
        $options_data = $this->options; // Use the potentially formatted options

        // Check if options array contains 'callback_translate' key
        if (isset($options_data['callback_translate'])) {
            $callback_translate = $options_data['callback_translate'];
            // Remove it from options as it's not an actual option for select
            unset($options_data['callback_translate']);
        }

        $_select_attrs = $this->attrs;
        if (!isset($_select_attrs['data-width'])) {
            $_select_attrs['data-width'] = '100%';
        }
        if (!isset($_select_attrs['data-none-selected-text'])) {
            $_select_attrs['data-none-selected-text'] = _('dropdown_non_selected_tex');
        }
        $_select_attrs_str = $this->buildAttributes($_select_attrs);

        $select_class_final = !empty($this->select_class) ? ' ' . $this->select_class : '';

        $select_html = '<div class="controls">';
        $select_html .= '<select id="' . htmlspecialchars($this->name) . '" name="' . htmlspecialchars($this->name) . '" class="selectpicker' . htmlspecialchars($select_class_final) . '" ' . $_select_attrs_str . ' data-live-search="true">';
        if ($this->include_blank) {
            $select_html .= '<option value="">' . htmlspecialchars(_($this->label)) . '</option>';
        }

        // Ensure option_attrs are set before trying to access them
        if (empty($this->option_attrs) && !empty($options_data) && is_string(reset($options_data))) {
            // This case should ideally be handled by the constructor/options() method,
            // but as a fallback, ensure default attrs if it somehow reaches here with simple strings
            $this->option_attrs = ['id', 'name'];
        }

        foreach ($options_data as $option) {
            $val = '';
            $_selected = '';
            $key = '';

            // Safely access option_attrs elements
            $value_key = $this->option_attrs[0] ?? null;
            $text_key = $this->option_attrs[1] ?? null;
            $subtext_key = $this->option_attrs[2] ?? null;

            if ($value_key && isset($option[$value_key]) && !empty($option[$value_key])) {
                $key = $option[$value_key];
            }

            if ($text_key) {
                if (!is_array($text_key)) {
                    $val = $option[$text_key] ?? '';
                } else {
                    foreach ($text_key as $_val) {
                        $val .= ($option[$_val] ?? '') . ' ';
                    }
                }
            }
            $val = trim($val);

            if ($callback_translate != '') {
                if (function_exists($callback_translate) && is_callable($callback_translate)) {
                    $val = call_user_func($callback_translate, $key);
                }
            }

            $data_sub_text = '';
            $is_selected = false;
            if (!is_array($this->selected)) {
                if ((string)$this->selected === (string)$key) {
                    $is_selected = true;
                }
            } else {
                foreach ($this->selected as $id) {
                    if ((string)$key === (string)$id) {
                        $is_selected = true;
                        break;
                    }
                }
            }
            if ($is_selected) {
                $_selected = ' selected';
            }

            if ($subtext_key) {
                if (strpos($subtext_key, ',') !== false) {
                    $sub_text = '';
                    $_temp = explode(',', $subtext_key);
                    foreach ($_temp as $t) {
                        if (isset($option[$t])) {
                            $sub_text .= $option[$t] . ' ';
                        }
                    }
                } else {
                    if (isset($option[$subtext_key])) {
                        $sub_text = $option[$subtext_key];
                    } else {
                        $sub_text = $subtext_key; // Fallback to literal string if key not found
                    }
                }
                $data_sub_text = ' data-subtext="' . htmlspecialchars($sub_text) . '"';
            }
            $data_content = '';
            if (isset($option['option_attributes'])) {
                foreach ($option['option_attributes'] as $_opt_attr_key => $_opt_attr_val) {
                    $data_content .= htmlspecialchars($_opt_attr_key) . '="' . htmlspecialchars($_opt_attr_val) . '"';
                }
                if ($data_content != '') {
                    $data_content = ' ' . $data_content;
                }
            }
            $select_html .= '<option value="' . htmlspecialchars($key) . '"' . $_selected . $data_content . $data_sub_text . '>' . htmlspecialchars($val) . '</option>';
        }
        $select_html .= '</select>';
        $select_html .= '</div>';

        // Add input group addon if specified
        if ($this->input_group_contents !== null) {
            // The class for the input group needs to be on the form-group div, not the select itself.
            // This part of the logic needs to be carefully handled to avoid breaking the form-group wrapper.
            // For simplicity, we'll apply it to the outer wrapper if it's an input group select.
            // This might require re-thinking how wrapInFormGroup is used or the structure of the select.
            // For now, let's adjust the wrapper class directly.
            $this->form_group_class .= ' input-group input-group-select select-' . htmlspecialchars($this->name);
            $select_html = str_replace('</select>', '</select><div class="input-group-addon">' . $this->input_group_contents . '</div>', $select_html);

            // Re-parse label to move it outside the input-group if it was inside
            $re = '/<label.*<\/label>/i';
            preg_match($re, $select_html, $label_match);

            if (count($label_match) > 0) {
                $select_html = preg_replace($re, '', $select_html);
                $select_html = $label_match[0] . $select_html; // Prepend label
            }
        }

        // Handle required indicator in label (if applicable, usually select itself has required)
        $label_html = '';
        if ($this->label !== '') {
            $label_html .= '<label for="' . htmlspecialchars($this->name) . '" class="control-label">' . htmlspecialchars(_($this->label));
            if (isset($this->attrs['required']) && $this->attrs['required']) {
                $label_html .= '<span class="required text-danger" style="margin-left:5px">*</span>';
            }
            $label_html .= '</label>';
        }

        // If it's an input group, the outer wrapper should be the input-group.
        // The wrapInFormGroup needs to be called with the correct classes.
        $wrapped_html = $this->wrapInFormGroup($label_html . $select_html, false); // Pass false for $include_label

        // If it was an input group, we need to adjust the outer div's class again
        if ($this->input_group_contents !== null) {
            // This is a bit hacky, but to avoid major refactoring of wrapInFormGroup for input-group
            // we'll replace the class on the outermost div generated by wrapInFormGroup
            $wrapped_html = str_replace(
                'class="form-group' . htmlspecialchars(' input-group input-group-select select-' . htmlspecialchars($this->name)) . '"',
                'class="form-group input-group input-group-select select-' . htmlspecialchars($this->name) . '"',
                $wrapped_html
            );
        }

        return $wrapped_html;
    }
}
