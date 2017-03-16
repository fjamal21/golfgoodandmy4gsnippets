<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractDataValue;

class UserVideo extends AbstractDataValue
{
    /*
     * Urls
     */
    private $valid_url_bases = array(
        'www.youtube.com',
        'youtu.be',
        'vimeo.com'
    );
    
    /*
     * Source of the video
     */
    private $source = null;
    private $host = null;
    private $video_id = null;
    
    /*
     * Error message
     */
    protected $message = null;
    
    /*
     * Check for validity
     */
    public function isValid()
    {
        if ( ! $this->value ) {
            return true;
        }
        
        if ( ! filter_var( $this->value, FILTER_VALIDATE_URL ) ) {
            $this->message = 'Invalid url.';
            return false;
        }
        
        if ( ! $this->setVideoSourceAndId() ) {
            $this->message = 'The video must be a valid YouTube or Vimeo URL.';
            return false;
        }
        
        return true;
    }
    
    
    /*
     * Display the video
     */
    public function display()
    {
        if ( ! $this->setVideoSourceAndId() ) {
            return;
        }
        
        $start = '<div class="video-widescreen">';
        
        $end = '</div>';
        
        $middle = $this->getEmbedCode();
        
        echo $start . $middle . $end;
    }
    
    /*
     * Is valid to display
     */
    public function setVideoSourceAndId()
    {
        // Is there a value?
        if ( ! $this->value ) {
            return false;
        }
        
        // Is it youtube or vimeo?
        if ( ! $this->setSource() ) {
            return false;
        }
        
        // Set the video id
        if ( ! $this->setVideoId() ) {
            return false;
        }
        
        return true;
    }
    
    /*
     * Set the source of the video (youtube or vimeo)
     */
    private function setSource()
    {
        $parts = parse_url( $this->value );
        //print_r($parts);
        
        if ( ! isset( $parts['host'] ) ) {
            return false;
        }
        
        $host = $parts['host'];
        
        if ( in_array( $host, array( 'www.youtube.com', 'youtu.be' ) ) ) {
            $this->source = 'youtube';
            $this->host = $host;
            return true;
        }
        elseif ( $host == 'vimeo.com' ) {
            $this->source = 'vimeo';
            $this->host = $host;
            return true;
        }
        
        return false;
    }
    
    /*
     * Set the video id
     */
    private function setVideoId()
    {
        if ( ! $this->value || ! $this->source ) {
            return false;
        }
        
        if ( $this->source == 'youtube' ) {
            return $this->setYoutubeVideoId();
        }
        if ( $this->source == 'vimeo' ) {
            return $this->setVimeoVideoId();
        }
        return false;
    }
    
    /*
     * Set a YouTube video id
     */
    private function setYoutubeVideoId()
    {
        if ( $this->host == 'www.youtube.com' ) {

            $query = parse_url( $this->value, PHP_URL_QUERY );
        
            if ( ! $query ) {
                $this->message = 'There is no video id in the url.';
                return false;
            }
            
            if ( strpos( $query, 'v=' ) != 0 ) {
                return false;
            }
            
            $id = substr( $query, 2 );
            
            $this->video_id = htmlspecialchars( $id );
            return true;
            
        }
        
        if ( $this->host == 'youtu.be' ) {
            
            $path = parse_url( $this->value, PHP_URL_PATH );
            
            if ( ! $path ) {
                $this->message = 'There is no video id in the url.';
                return false;
            }
        
            $path = trim( $path, '/' );
            $this->video_id = $path;
            return true;
            
        }
    }
    
    /*
     * Set a Vimeo video id
     */
    private function setVimeoVideoId()
    {
        $path = parse_url( $this->value, PHP_URL_PATH );
        
        if ( ! $path ) {
            $this->message = 'There is no video id in the url.';
            return false;
        }
        
        $path = trim( $path, '/' );
        $this->video_id = $path;
        return true;
    }
    
    /*
     * Get the embed code
     */
    public function getEmbedCode()
    {
        if ( $this->source == 'youtube' ) {
            return $this->getYoutubeEmbedCode();
        }
        
        if ( $this->source == 'vimeo' ) {
            return $this->getVimeoEmbedCode();
        }
    }
    
    /*
     * Get YouTube embed code
     */
    private function getYoutubeEmbedCode()
    {
    	$player = '<iframe src="//www.youtube.com/embed/' . $this->video_id;
    	$player .= '?autohide=1&controls=2&modestbranding=1&playinline=0&rel=0&showinfo=0';
    	$player .= '" frameborder="0"></iframe>';
        
        return $player;
    }
    
    /*
     * Get Vimeo embed code
     */
    private function getVimeoEmbedCode()
    {
        $player = '<iframe src="//player.vimeo.com/video/' . $this->video_id;
        $player .= '?portrait=0&title=0&byline=0&badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        
        return $player;
    }
    
    /*
     * Get sanitized version
     */
    public function getSanitized()
    {
        return filter_var( $this->value, FILTER_SANITIZE_URL );
    }
    
    /*
     * Return the error message
     */
    public function getError()
    {
        return $this->message;
    }
}
