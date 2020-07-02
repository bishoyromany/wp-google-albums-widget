<?php 
require_once(__DIR__.'/../../Widgets/googleAlbumAPI.php');

use Includes\Widgets\GoogleAlbumApi;
/**
 * prepare script functions
 */
$serve = new GoogleAlbumApi();
$serve->album = $album_url;
/**
 * check data option
 */
$checker = $serve->check();
/**
 * if no images exist or images updated since long time, scrape images
 */
if(!$checker){
    $serve->scrape();
    $serve->saveImages();
}

$images = $serve->response();

$x = 0;
?>

<style>
    #GoogleSliderInside .et-pb-controllers{
        display : none;
    }
    #GoogleSliderInside .title{
        padding : 10px;
        
    }
    #GoogleSliderInside .title span{
        font-weight : bold;
        color : #003060;
    }
</style>

<div id="GoogleSliderInside" style="height : 100%;    overflow: hidden;">
    <div class="et_pb_module_header title" style="text-align: center;">
        <span><?php echo $title; ?></span>
		<a id="ToggleMinistries" class="et_pb_button toggle-ministires et_pb_bg_layout_light"  target="_blank" href="<?php echo $album_url; ?>">More </a>
    </div>
	<div style="height : CALC(100% - 88px); margin-bottom : 10px;" class="et_pb_module et_pb_gallery et_pb_gallery_0  et_pb_slider et_pb_gallery_fullwidth et_slide_transition_to_next et_pb_bg_layout_light">
        <div style="height : 100%;" class="et_pb_gallery_items et_post_gallery clearfix" data-per_page="4">
            <?php foreach($images as $image): $x ++; 
                if($x >= $maximum_allowed_images && $maximum_allowed_images > -1){ break; }
            ?>
            <div 
                class="et_pb_gallery_item et_pb_bg_layout_light" 
                style="<?php if($x == 1){ echo "z-index: 1; display: block; opacity: 1;"; }else{ echo "z-index: 0; display: none; opacity: 0;"; } ?>height:100%;">
                    <div class="et_pb_gallery_image landscape" style="height : auto;">
                        <a href="<?php echo $image; ?>" title="" style="height : auto;">
                        <img src="<?php echo $image; ?>" alt="" style="width : 100%; height : auto;">
                        <span class="et_overlay" style="height : 100%;"></span>
                    </a>
                </div>
            </div>    
            <?php endforeach; ?>   
        </div><!-- .et_pb_gallery_items -->
    </div>
    <h4 style="max-height : 35px; padding : 0px; text-align:center;" class="et_pb_module_header album-title"><span><?php echo $serve->albumTitle(); ?></span></h4>
    <!-- <div class="et-pb-slider-arrows">
        <a class="et-pb-arrow-prev" href="#"><span>Previous</span></a>
        <a class="et-pb-arrow-next" href="#"><span>Next</span></a>
    </div>
    <div class="et-pb-controllers" style="display:none;"></div> -->
</div>