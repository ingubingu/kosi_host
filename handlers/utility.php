<?php

class Utility {

    public static function output($value) {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }

    public static function redirect($url) {
        header("Location: ../redirects/$url.php");
        exit();
    }

    public static function vdirect($url) {
        header("Location: ../views/$url.php");
        exit();
    }

    public static function render_view($view, $variables = []) {
        extract($variables); // Extract the array to variables
        ob_start();
        include __DIR__ . "/views/$view.php";
        return ob_get_clean();
    }
}
