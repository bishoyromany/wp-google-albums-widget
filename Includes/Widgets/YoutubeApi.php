<?php 
namespace Includes\Widgets;
class YoutubeApi{
    private $apiUrl = 'https://www.googleapis.com/youtube/v3/search';
    public $youtubeApiKey = 'AIzaSyDeNEZxNJgESGmVspNHMn0p3Po4-LB93vY';
    public $channelId = 'UCmxNofANlC5f8CFBwaJ74hA';
    private $saveDir = __DIR__.'/../../caches/YoutubeLastVideo.json';
    private $checkTime = 60 * 5;
    private $video = [];
    private $liveBroadcast = __DIR__.'/../../caches/liveBroadcast.txt';
    private $haveBroadcast = false;

    // get channel videos
    public function getChannelVideos($pageToken = null){
        $api_url = $this->apiUrl;
        $apiKey = $this->youtubeApiKey;
        $channelId = $this->channelId;
    
        $params = [
            'part' => 'snippet,id',
            'maxResults' => 20,
            'channelId' => $channelId,
            'key' => $apiKey,
            'order' => 'date',
            'pageToken' => $pageToken,
        ];
        
        $query = http_build_query($params);
        
        $url = $api_url.'?'.$query;
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        
        $youtuneData = json_decode(curl_exec($curl));
        
        curl_close($curl);
    
        return $youtuneData;
    }
    

    // get last channel video
    public function scrapeLastVideo(){
        $check = $this->checkIfExist();
        if(!$check){
            $data = $this->getChannelVideos();
            $items = isset($data->items) ? $data->items : [];
            if(!empty($items)){
                $item = $items[0];
                $this->video = (object)[
                    'publishedAt' => $item->snippet->publishedAt,
                    'channelId' => $item->snippet->channelId,
                    'videoId' => $item->id->videoId,
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'images' => $item->snippet->thumbnails,
                    'liveBroadCast' => 0,
                ];  

                foreach($items as $item){
                    $snip = $item->snippet;
                    if(!$this->haveBroadcast){
                        $this->haveBroadcast = $snip->liveBroadcastContent == 'live' ? 1 : 0;
                    }
                }
                $this->video->liveBroadCast = $this->haveBroadcast;
            }
            if(!empty($this->video && isset($this->video->title))){
                $this->saveVideo();
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
        $this->video = (object)$data->video;
        return true;
    }

    public function getVideo(){
        return $this->video;
    }

    public static function dd($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }

    /**
     * save images function
     */
    public function saveVideo(){
        file_put_contents($this->saveDir, json_encode(
            [
                'last_check_time' => time(),
                'next_check_time' => time() + $this->checkTime,
                'last_check_human_time' => date('Y-m-d H:i:s'),
                'video' => $this->getVideo(),
                'next_check' => date('Y-m-d H:i:s' , time() + $this->checkTime)
            ]
        ));
    }

    // /**
    //  * update broadcast
    //  */
    // public function broadcast(){
    //     /**
    //      * check if video exist or no
    //      */
    //     $watchFile = $this->liveBroadcast;
    //     if(!file_exists($watchFile)){
    //         file_put_contents($watchFile , 'alive');
    //     }
    //     $checkTime = 60;
    //     $youtube_file_creation_date = json_decode(file_get_contents($watchFile));
    //     if(isset($youtube_file_creation_date->last_check_time)){
    //         $lastChecked = $youtube_file_creation_date->last_check_time < time() - $checkTime;
    //     }else{
    //         $lastChecked = true;
    //     }


    //     if($lastChecked){
    //         $youtubeData = getChannelVideos();

    //         if(isset($youtubeData->items)){
    //             $items = $youtubeData->items;
    //             $hasLive = false;
    //             foreach($items as $item){
    //                 $snip = $item->snippet;
    //                 $hasLiveBroadcast = $snip->liveBroadcastContent == 'live' ? true : false;
    //                 if($hasLiveBroadcast){
    //                     $hasLive = true;
    //                     $updateData = json_encode([
    //                         'has_live_broadcast' => 1,
    //                         'last_check_time' => time(),
    //                         'last_check_human_time' => date('Y-m-d H:i:s'),
    //                         'live_video_data' => $item,
    //                         'next_check' => date('Y-m-d H:i:s' , time() + $checkTime),
    //                     ]);
    //                     file_put_contents($watchFile , $updateData);
    //                     break;
    //                 }
    //             }

    //             if(!$hasLive){
    //                 $updateData = json_encode([
    //                     'has_live_broadcast' => 0,
    //                     'last_check_time' => time(),
    //                     'last_check_human_time' => date('Y-m-d H:i:s'),
    //                     'next_check' => date('Y-m-d H:i:s' , time() + $checkTime),
    //                 ]);
    //                 file_put_contents($watchFile , $updateData);
    //             }
    //         }
    //     }

    //     $isVideoOnline = json_decode(file_get_contents($watchFile));
    //     if(isset($isVideoOnline->has_live_broadcast)){
    //         $isVideoOnline = $isVideoOnline->has_live_broadcast == 1 ? true : false;
    //     }else{
    //         $isVideoOnline = false;
    //     }

    //     $isVideoOnline = $isVideoOnline ? 'live_streaming0.jpg' : 'live_streaming_none.jpeg';
    // }

    // /**
    //  * get broadcast
    //  */
    // public function addBroadcast(){
    //     return $this->haveBroadcast;
    // }



    public function checkIfVideoExist($videoId){
        global $wpdb;
        $posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
        WHERE meta_key = 'videoId' AND  meta_value = '".$videoId."' LIMIT 1");
        return $posts;
    }
    
    public function generateSermonContent($post){
        return '
            <!-- wp:html -->
            <figure><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$post["meta_input"]["videoId"].'" allowfullscreen=""></iframe></figure>
            <!-- /wp:html -->
    
            <!-- wp:paragraph -->
            <p>'.$post["post_excerpt"].'</p>
            <!-- /wp:paragraph -->
        ';
    }

    public function Generate_Featured_Image( $image_url, $post_id  ){
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = $post_id.basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);
    
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        $res2= set_post_thumbnail( $post_id, $attach_id );
    }
    
    public function getYoutubeSermons($pageToken = ''){
        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems';
        $apiKey = $this->youtubeApiKey;
        $playlistId = 'PL67376272A5E485C7';
    
        $params = [
            'part' => 'snippet,contentDetails',
            'maxResults' => 50,
            'playlistId' => $playlistId,
            'key' => $apiKey,
            'pageToken' => $pageToken,
        ];
        
        $query = http_build_query($params);
        
        $url = $api_url.'?'.$query;
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        
        $youtuneData = json_decode(curl_exec($curl));
        
        curl_close($curl);
    
        return $youtuneData;
    }    
}

/*
<?php echo get_template_directory_uri(); ?>/images/church/<?php echo $isVideoOnline; ?>
*/





// ?key=AIzaSyDeNEZxNJgESGmVspNHMn0p3Po4-LB93vY&channelId=UCmxNofANlC5f8CFBwaJ74hA&part=snippet,id&order=date&maxResults=20