<?php
namespace Includes\Api;
require_once(__DIR__.'/CallBack.php');

class SettingsApi{

    public $admin_pages = [];
    public $addSubPages = false;
    public $fields = [];

    public function register(){
        if(!empty($this->admin_pages)){
            add_action('admin_menu' , [$this, 'addAdminMenu']);
        }

        if(!empty($this->fields)){
            add_action('admin_init', [$this, 'registerCustomField']);
        }
    }

    public function addPages(array $pages){
        $this->admin_pages = $pages;   

        return $this;
    }

    public function withSubPages(bool $subPages){
        $this->addSubPages = $subPages;
        return $this;
    }

    public function addAdminMenu(){
        $pages = $this->admin_pages;
        foreach($pages as $page){
            add_menu_page($page['title'], $page['name'], $page['role'], $page['slug'], 
            $page['function'], $page['icon'], $page['order']);
            if($this->addSubPages && isset($page['subPages'])){
                foreach($page['subPages'] as $subPage){
                    if(isset($subPage['clone']) && $subPage['clone']){
                        add_submenu_page($page['slug'], $subPage['title'], $page['name'], $page['role'], 
                        $page['slug'], $page['function']);
                    }else{
                        add_submenu_page($page['slug'], $subPage['title'], $subPage['name'], $subPage['role'], 
                        $subPage['slug'], $subPage['function']);
                    }
                }
            }
        }
    }

    // add fields
    public function addFields(array $fields){
        $this->fields = $fields;   
        return $this;
    }

    /**
     * register custom field
     */
    public function registerCustomField(){
        foreach($this->fields as $field){
            foreach($field as $key => $value){
                if($key == 'option'){
                    foreach($value as $v){
                        // register settings
                        register_setting( 
                            $v['option_group'], 
                            $v['option_name'], 
                            (
                                isset($v['callback']) 
                                ? $v['callback'] : ''
                            )
                        );
                    }
                }elseif($key == 'section'){
                    foreach($value as $v){
                        // add settigns section 
                        add_settings_section(
                            $v['id'], 
                            $v['title'], 
                            (
                                isset($v['callback']) 
                                ? $v['callback'] : ''
                            ), $v['page']
                        );
                    }
                }elseif($key == 'field'){
                    foreach($value as $v){
                        // add settings field
                        add_settings_field($v['id'], 
                            $v['title'], 
                            (
                                isset($v['callback']) 
                                ? $v['callback'] : ''
                            ), 
                            $v['page'], 
                            $v['section'], 
                            (
                                isset($v['args']) 
                                ? $v['args'] : ''
                            )
                        );
                    }
                }
            }



        }
    }
}