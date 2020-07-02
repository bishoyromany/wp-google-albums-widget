<h1>Google Albums</h1>
    
<?php 
    /**
     * display settings error
     */
    settings_errors();
?>


<form method="post" action="options.php">
    <?php 
        settings_fields('google_albums_settings');
        do_settings_sections('google-albums-widget-settings');
        submit_button();
    ?>

</form>