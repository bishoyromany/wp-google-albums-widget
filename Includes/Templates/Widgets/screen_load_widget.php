<style>
.loaderBackgroundContainer {
    z-index: 100000000000;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    background-color: #fff;
    background-image: url(<?php echo $background_image; ?>);
    background-position: center top;
    background-size: auto;
    background-repeat: repeat;
    background-attachment: fixed;
    position: fixed;
    top : 0px;
    left : 0px;
}
 .loaderBackgroundContainer .overly {
    position: fixed;
    width: 100%;
    height: 100%;
    background: <?php echo $overlay_color; ?>;
    top: 0px;
    left: 0px;
    opacity: 0.8;
}
 .loaderBackgroundContainer .loader {
    display: flex;
    margin: 100px auto;
    height: 200px;
    width: 200px;
    font-weight: bold;
    color: red;
    font-size: 30px;
    position: relative;
    border-radius: 50%;
    line-height: 200px;
    text-align: center;
    align-items: center;
}
 .loaderBackgroundContainer .loader::first-letter {
	color: lightskyblue;
}
 .loaderBackgroundContainer .loader:before {
	 border: 3px <?php echo $second_circle_color; ?> solid;
	 border-top-color: transparent;
	 content: "";
	 width: 150px;
	 height: 150px;
	 position: absolute;
	 border-radius: 50%;
	 top: 25px;
	 left: 25px;
	 transform: rotate(0deg);
	 animation: rotate_small infinite linear 4s;
}
 .loaderBackgroundContainer .loader::after {
	 content: "";
	 left: 0px;
	 border: 3px solid <?php echo $first_circle_color; ?>;
	 border-top-color: transparent;
	 width: 200px;
	 height: 200px;
	 position: absolute;
	 right: 0px;
	 border-radius: 50%;
	 transform: rotate(0deg);
	 animation: rotate_big infinite linear 4s;
}
 .loaderBackgroundContainer .loader img {
	 display: block;
	 margin: 0px auto;
	 animation: pulse infinite cubic-bezier(0.35, 0.21, 0.38, 0.85) 3s;
}
 @keyframes rotate_small {
	 0% {
		 transform: rotate(0deg);
	}
	 100% {
		 transform: rotate(360deg);
	}
}
 @keyframes rotate_big {
	 0% {
		 transform: rotate(0deg);
	}
	 100% {
		 transform: rotate(-360deg);
	}
}
 @keyframes pulse {
	 0% {
		 margin-top: 0px;
	}
	 50% {
		 margin-top: 30px;
	}
	 100% {
		 margin-top: 0px;
	}
}
 
</style>
<div class="loaderBackgroundContainer">
  <div class="overly"></div>
  <div class="loader"><img src="<?php echo $stmary_image; ?>" width="100px" height="100px" /></div>
</div>
<script>
/**
 * hide the loader
 */
const hideLoadingScreen = _ => {
    let element = document.getElementsByClassName('loaderBackgroundContainer');
    if(element.length > 0){
        element = element[0];
        element.style.opacity = 0;
        setTimeout(() => element.remove() ,500);
    }
};
document.addEventListener('readystatechange', event => {
    if (event.target.readyState === 'complete') {
        hideLoadingScreen();
    }
});
</script>