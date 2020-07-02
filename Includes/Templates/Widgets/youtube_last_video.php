<?php 
require_once(__DIR__.'/../../Widgets/YoutubeApi.php');

use Includes\Widgets\YoutubeApi;
/**
 * prepare script functions
 */
$serve = new YoutubeApi();
if(!empty($api_token)){
    $serve->youtubeApiKey = $api_token;
}
if(!empty($channel_id)){
    $serve->channelId = $channel_id;
}
$serve->scrapeLastVideo();
$video = $serve->getVideo();
?>

<style>
    #YoutuneLastVideoWidget .title{
        padding : 10px;
        
    }
    #YoutuneLastVideoWidget .title span{
        font-weight : bold;
        color : #003060;
    }
</style>

<!-- id="youTubeSection"  -->
<div id="YoutuneLastVideoWidget" style="height : 100%;overflow:hidden;">
    <div class="et_pb_module_header title" style="text-align: center;">
        <span><?php echo $title; ?></span>
		<a id="ToggleMinistries" class="et_pb_button toggle-ministires et_pb_bg_layout_light"  target="_blank" href="<?php echo $channel_url; ?>">More </a>
    </div>
    <?php if(!empty($video) && isset($video->title)): ?>
        <a style="height : CALC(100% - 88px); display:block; overflow: hidden;" href="https://www.youtube.com/watch?v=<?php echo $video->videoId ?>" target="_blank">
            <img src="<?php
                if(isset($video->images->high)){
                    echo $video->images->high->url;
                }elseif(isset($video->medium->high)){
                    echo $video->images->medium->url;
                }elseif(isset($video->default->high)){
                    echo $video->images->default->url;
                }else{
                    echo "http://minasidhom.com/wp-content/uploads/2020/03/YouTube-Logo-300x169.png";
                }
            ?>" style="width:100%;height:auto;" alt="<?php echo $video->title; ?>"/>
        </a>
        <h4 style="max-height : 100%; padding : 10px 0px 0px 0px;" class="et_pb_module_header"><span><?php echo $video->title; ?></span></h4>
        <?php if($video->liveBroadCast): ?>
            <script>
                window.addEventListener('load', function () {
                    var target = document.getElementById('liveBroadcast').childNodes[1].childNodes[0];
                    target.innerHTML = `<img alt="" title="streaming" 
                    src="<?php echo get_template_directory_uri(); ?>/images/church/live_streaming0.png"
                    data-src="<?php echo get_template_directory_uri(); ?>/images/church/live_streaming0.png" />`;
                });

                // var target = document.getElementById('liveBroadcast').childNodes[1].childNodes[0];
                // target.src = "<?php echo get_template_directory_uri(); ?>/images/church/live_streaming0.png";
                // target.srcset = "<?php echo get_template_directory_uri(); ?>/images/church/live_streaming0.png";
            </script>
        <?php endif; ?>
    <?php else: ?>
        NO Videos Exist
    <?php endif; ?>
</div>