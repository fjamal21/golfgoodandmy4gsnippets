<?php
namespace Src\Includes;

use Src\Includes\AllowedImageTypes;
use Src\Config\Config;

class Image
{
    /*
     * Error marker
     */
    private $error;
    private $message;
    
    /*
     * The value in the $_FILES array to look for
     */
    private $post_name;
    
    /*
     * The upload directory
     */
    private $dir;
    
    /*
     * File attributes
     */
    private $tmp_name;
    private $file_type;
    private $file_extension;
    private $file_name;
    private $file_size;
    private $error_code;
    
    /*
     * Get
     */
    public function get( $key )
    {
        return $this->$key;
    }
    
    /*
     * Get the full name with the extension
     */
    public function getFullName()
    {
        return $this->file_name . '.' . $this->file_extension;
    }
    
    /*
     * Set name
     */
    public function setPostName( $name )
    {
        $this->post_name = $name;
    }
    
    /*
     * Set the temp path
     */
    public function setImage()
    {
        if ( ! $this->post_name ) {
            // $this->message = 'Internal error. Input field name not set.';
            return false;
        }
        
        if ( empty( $_FILES[$this->post_name]['tmp_name'] ) ) {
            // $this->message = 'File not found.';
            return false;
        }
        
        $allowed_image_types = new AllowedImageTypes;
        $types = $allowed_image_types->get();
        
	    $this->file_type = $_FILES[$this->post_name]['type'];
        
        if ( ! array_key_exists( $this->file_type, $types ) ) {
            $this->message = 'FILE TYPE NOT ALLOWED';
            return false;
        }
        
        $this->file_extension = $types[$this->file_type];
        
        $this->tmp_name = $_FILES[$this->post_name]['tmp_name'];
        $this->file_size = $_FILES[$this->post_name]['size'];
        $this->error_code = $_FILES[$this->post_name]['error'];
        $this->file_name = pathinfo( $_FILES[$this->post_name]['name'], PATHINFO_FILENAME);
        
        // Filter out unwanted characters from the file name and remove spaces
        $this->file_name = str_replace( ' ', '-', $this->file_name );
        $this->file_name = preg_replace( '/[^a-zA-Z0-9_-]/', '', $this->file_name );
        
        return true;
    }
    
    /*
     * Move the image to the correct directory
     */
    public function moveTo( $dir )
    {
        $location = $dir . '/' . basename( $this->file_name ) . '.' . $this->file_extension;
		move_uploaded_file($this->tmp_name, $location);
		unset($_FILES[$this->post_name]);
    }
}
