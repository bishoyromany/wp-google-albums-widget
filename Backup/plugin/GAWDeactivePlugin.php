<?php 
namespace Includes\Plugin;
class GAWDeactivePlugin{
    public static function deactivate(){
        // flush rewrite rules
        flush_rewrite_rules();
    }

}