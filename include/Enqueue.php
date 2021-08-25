<?php


namespace DWP;


class Enqueue
{
    function __construct()
    {
        add_action( 'admin_enqueue_scripts', array($this, 'add_enqueue_plugin') );
    }
    function add_enqueue_plugin(){
        wp_enqueue_style( 'select2', DWP_DIR . 'public/css/select2.css');
        wp_enqueue_script( 'select2', DWP_DIR . 'public/js/select2.js');
        wp_enqueue_script( 'script-dw', DWP_DIR . 'public/js/script.js');
    }
}