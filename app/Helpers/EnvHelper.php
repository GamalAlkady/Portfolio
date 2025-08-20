<?php

/**
 * Helper functions for managing .env file
 */

if (!function_exists('updateEnvFile')) {
    /**
     * Update .env file with new values
     * @param array $data Key-value pairs to update
     * @return bool
     */
    function updateEnvFile(array $data): bool
    {
        $envPath = APP_ROOT . '/.env';
        
        if (!file_exists($envPath)) {
            return false;
        }
        
        $envContent = file_get_contents($envPath);
        
        foreach ($data as $key => $value) {
            // Escape special characters in value
            $value = addslashes($value);
            
            // Check if key exists in .env file
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}='{$value}'";
            
            if (preg_match($pattern, $envContent)) {
                // Update existing key
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // Add new key at the end
                $envContent .= "\n{$replacement}";
            }
        }
        
        return file_put_contents($envPath, $envContent) !== false;
    }
}

if (!function_exists('getEnvValue')) {
    /**
     * Get value from .env file
     * @param string $key
     * @param string $default
     * @return string
     */
    function getEnvValue(string $key, string $default = ''): string
    {
        $envPath = APP_ROOT . '/.env';
        
        if (!file_exists($envPath)) {
            return $default;
        }
        
        $envContent = file_get_contents($envPath);
        $pattern = "/^{$key}=(.*)$/m";
        
        if (preg_match($pattern, $envContent, $matches)) {
            return trim($matches[1], '"\'');
        }
        
        return $default;
    }
}

if (!function_exists('validateEmailSettings')) {
    /**
     * Validate email settings
     * @param array $settings
     * @return array
     */
    function validateEmailSettings(array $settings): array
    {
        $errors = [];
        
        // Validate SMTP host
        if (empty($settings['mail_host'])) {
            $errors[] = __('smtp_host_required');
        }
        
        // Validate SMTP port
        if (empty($settings['mail_port']) || !in_array($settings['mail_port'], ['25', '465', '587'])) {
            $errors[] = __('smtp_port_invalid');
        }
        
        // Validate username (should be email)
        if (!empty($settings['mail_username']) && !filter_var($settings['mail_username'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = __('smtp_username_invalid');
        }
        
        // Validate from address
        if (!empty($settings['mail_from_address']) && !filter_var($settings['mail_from_address'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = __('from_email_invalid');
        }
        
        return $errors;
    }
}
