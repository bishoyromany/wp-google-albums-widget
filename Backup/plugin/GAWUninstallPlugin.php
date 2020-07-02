<?php 
class GAWUninstallPlugin{
    private $deletePostTypes = [
        'sermon', 'book',
    ];

    public function __construct(){
        global $wpdb;

        $this->prefix = $wpdb->prefix;
    }

    /**
     * uninstall everything
     */
    public function Uninstall(){
        $this->removePosts();
        $this->removePostsMeta();
        $this->removePostsTermRelationship();
    }

    /**
     * remove posts
     */
    public function removePosts(){
        foreach($this->deletePostTypes as $type){
            $wpdb->query("DELETE FROM ".$this->prefix."_posts WHERE `post_type` = '$type'");
        } 
    }

    /**
     * remove ports meta
     */
    public function removePostsMeta(){
        $wpdp->query(
            "DELETE FROM ".$this->prefix.
            "_postmeta WHERE `post_id` NOT IN (SELECT ID from ".$this->prefix."_posts)" 
        );
    }   


    /**
     * remove ports term_relationship
     */
    public function removePostsTermRelationship(){
        $wpdp->query(
            "DELETE FROM ".$this->prefix.
            "_term_relationship WHERE `object_id` NOT IN (SELECT ID from ".$this->prefix."_posts)" 
        );
    } 

}