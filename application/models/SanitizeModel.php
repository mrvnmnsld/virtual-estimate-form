<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SanitizeModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to sanitize input data
    private function sanitize_input($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize_input($value); // Recursive call for nested arrays
            }
        } else {
            // Strip unnecessary characters (extra space, tab, newline)
            $data = trim($data);
            // Remove backslashes (\)
            $data = stripslashes($data);
            // Convert special characters to HTML entities
            $data = htmlspecialchars($data);
        }
        return $data;
    }

    // Function to sanitize an array
    public function sanitize_array($input_array) {
        if (!is_array($input_array)) {
            return false; // Return false if the input is not an array
        }
        return $this->sanitize_input($input_array);
    }
}
