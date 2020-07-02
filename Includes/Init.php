<?php 
namespace Includes;
require_once(__DIR__.'/Base/Enq.php');
require_once(__DIR__.'/Pages/Admin.php');
require_once(__DIR__.'/Base/SettingsLinks.php');
require_once(__DIR__.'/Widgets/Init.php');

final class Init{

    /**
     * store all our clases and return them
     */
    public static function get_services(){
        return [
            Base\Enq::class,
            Pages\Admin::class,
            Base\SettingsLinks::class,
            Widgets\Init::class,
        ];
    }

    /**
     * call register function if exist in the class
     */
    public static function register_services(){
        foreach(self::get_services() as $class){
            $service = self::instantiate($class);

            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    /**
     * call the class or init it
     */
    private static function instantiate($class){
        return new $class();
    }

}





// use Includes\Plugin\GAWActivePlugin;
// use Includes\Plugin\GAWDeactivePlugin;

// if(!class_exists('googleAlbumsWedgit')){
//     define('GAW_PLUGIN_NAME' , plugin_basename(__FILE__));

//     require_once(__DIR__.'/vendor/autoload.php');

//     // /**
//     //  * autoloader
//     //  */
//     // require_once(__DIR__. '/includes/plugin/autoloader.php');

//     /**
//      * require widgets
//      */
//     require_once(__DIR__ . '/includes/widgets/widgets.php'); 


//     /**
//      * require needed classes
//      */
//     // require_once(__DIR__.'/includes/plugin/GAWActivePlugin.php');
//     // require_once(__DIR__.'/includes/plugin/GAWDeactivePlugin.php');

//     /**
//      * plugin class
//      */
//     class googleAlbumsWedgit{
//         /**
//          * auto call 
//          */
//         public function __construct(){
//             $this->activate();
//         }

//         /**
//          * activate plugin
//          */
//         public function activate(){
//             add_action('init', [new GAWActivePlugin, 'register']);
//         }

//         /**
//          * deactivate plugin
//          */
//         public function deactivate(){
//             GAWDeactivePlugin::deactivate();
//         }

//         // /**
//         //  * uninstall
//         //  */
//         // public static function uninstall(){

//         // }
//     }


//     // instance
//     $plugin = new googleAlbumsWedgit();
    
//     // activate 
//     register_activation_hook(__FILE__, [$plugin , 'activate']);

//     // deactivation 
//     register_deactivation_hook(__FILE__, [$plugin, 'deactivate']);

//     // uninstall
//     // register_uninstall_hook(__FILE__, [$plugin, 'uninstall']);
// }else{
//     echo "Class Already Exist";
// }