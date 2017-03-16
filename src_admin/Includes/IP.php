<?php
namespace Src\Includes;

class IP
{
    /*
     * Store the ip
     */
    private $ip = null;
    
    /*
     * Constructor sets the ip
     */
    public function __construct()
    {
        $this->setClientIp();
    }
    
    /*
     * Set the ip
     */
    private function setClientIp()
    {
    	$ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
 
        $this->ip = $ipaddress;
    }
    
    /*
     * Return the ip
     */
    public function get()
    {
        if ( $this->ip ) {
            return $this->ip;
        }
        return null;
    }
}
