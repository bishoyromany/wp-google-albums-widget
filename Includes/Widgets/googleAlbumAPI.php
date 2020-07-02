<?php 
namespace Includes\Widgets;
class GoogleAlbumApi{
    public $album = 'https://photos.app.goo.gl/zR8nUz3JXLerfEFk7';
    private $data;
    private $images = [];
    private $saveDir = __DIR__.'/../../caches/googleAlbums.json';
    private $saveDirJs = __DIR__.'/../../caches/js/generated.js';
    private $checkTime = 60;
    private $title = '';

    public function check(){
        return $this->checkIfExist();
    }

    /**
     * scrape the album data serve
     */
    public function scrape(){
        $this->sendScrapeRequest();
        $this->filterImages();
    }

    /**
     * send scrape request to scrape the album data
     */
    protected function sendScrapeRequest(){
        $this->data = file_get_contents($this->album);
    }

    /**
     * filter images
     */
    private function filterImages(){
        $this->title = $this->get_string_between($this->data, '<meta property="og:title" content="', '">');
        $preData = $this->get_string_between($this->data, 'AF_initDataCallback(' , ');');
        $filteredData = $this->get_string_between($preData, 'data:function(){return ', '}}');
        if(empty($filteredData)){
            $preData = preg_replace('/^{key: \'ds:0\', isError:  false , hash: \'1\', data:/i', '', $preData);
            $preData = preg_replace('/}$/i', '', $preData);
            $filteredData = $preData;
        }
        $preData = json_decode($filteredData, true);
        if(!empty($preData)){
            foreach($preData as $imgs){
                if(is_array($imgs)){
                    foreach($imgs as $img){
                        if(!empty($img)){
                            if(isset($img[1][0]) && @strlen($img[1][0]) > 10){ 
                                if(preg_match('/^http/i', $img[1][0])){
                                    $this->images[] = $img[1][0]; 
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * get string between 2 strings
     */
    public static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * check if images exist or no
     */
    public function checkIfExist(){
        $data = false;
        if(file_exists($this->saveDir)){
            $data = file_get_contents($this->saveDir);
        }else{
            return false;
        }
        if($data){
            $data = json_decode($data);
            if(isset($data->last_check_time) && isset($data->next_check_time)){
                if($data->next_check_time <= time()){
                    if(is_user_logged_in()){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
        $this->images = $data->images;

        $this->title = $data->title;
        return true;
    }

    /**
     * save images function
     */
    public function saveImages(){
        file_put_contents($this->saveDir, json_encode(
            [
                'last_check_time' => time(),
                'next_check_time' => time() + $this->checkTime,
                'last_check_human_time' => date('Y-m-d H:i:s'),
                'images' => $this->response(),
                'title'  => $this->title,
                'next_check' => date('Y-m-d H:i:s' , time() + $this->checkTime)
            ]
        ));
    }

    /**
     * return the response of the data
     */
    public function response(){
        return $this->images;
    }

    /**
     * get title
     */
    public function albumTitle(){
        return $this->title;
    }

    /**
     * generate javascript injection file
     */
    public function generateJSInjectionFile(){
        $elements = '';
        foreach($this->response() as $img){
            $element = '
                <div class="et_pb_gallery_item et_pb_bg_layout_light et-pb-active-slide">
                    <div class="et_pb_gallery_image landscape">
                        <a href="'.$img.'" title="">
                        <img src="'.$img.'" alt="">
                        <span class="et_overlay"></span>
                    </a>
                </div></div>            
            ';
            $elements .= $element;
        }
        $script = 'document.addEventListener("DOMContentLoaded", function() {';
        $script .= 'let checker = document.getElementById("GoogleSlider"); if(checker != null){';
        $script .= 'document.getElementsByClassName("et_pb_gallery_items")[0].innerHTML = `'.$elements. '`;';
        $script .= '}';
        $script .= '});';

        file_put_contents($this->saveDirJs , $script);
    }

    /**
     * debug
     */
    public function dd(...$data){
        foreach($data as $d){
            echo "<pre>";
            var_dump($d);
            echo "</pre>";
        }
        exit;
    }
}
