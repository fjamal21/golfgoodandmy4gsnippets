<?php
namespace Src\Config;

class Config
{
    /*
     * Database connection
     */
    private $dbname = 'g4g_2016_live';
    private $dbhost = 'localhost';
    private $dbuser = 'g4g_2016_admin';
    private $dbpass = '!tC6wa31';
    
    /*
     * Environment variable
     */
    private $live = false;
    private $url_rewriting = true;
    private $timezone = 'US/Eastern';
    
    /*
     * Sitewide configuration
     */
    private $site_name = 'golf4good';
    private $url = 'golf4good.golf';
    private $secure_url = 'http://golf4good.golf';
    private $site_email = 'admin@golf4good.golf';
    private $error_email = 'admin@golf4good.golf';
    private $charity_number = '82539 3176 RR0001';
    
    /*
     * Upload directories
     */
    private $upload_dir = 'uploads_2016_live';
    
    /*
     * Event dates
     */
    private $start_date = '07/18/2015';
    private $end_date = '08/18/2015';
    
    /*
     * Stripe keys
     */
    private $stripe_private_key = null;
    private $stripe_public_key = null;
    
    private function setStripeKeys()
    {
        if ( $this->live ) {
            $this->stripe_private_key = 'sk_test_R4ZmKpVbvlTlAUXiweAtS1Vd';
            $this->stripe_public_key = 'pk_test_uKjFrH08EsmiUcb6PBgom2Qc';
        } else {
            $this->stripe_private_key = 'sk_test_R4ZmKpVbvlTlAUXiweAtS1Vd';
            $this->stripe_public_key = 'pk_test_uKjFrH08EsmiUcb6PBgom2Qc';
        }
    }
    
    private function setEventDates()
    {
        date_default_timezone_set($this->timezone);
        $this->start_date = new \DateTime($this->start_date);
        $this->end_date = new \DateTime($this->end_date);
    }
    
    /*
     * Config instance
     */
    static private $instance = null;
    
    /*
     * Get instance
     */
    static public function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new Config();
        }
        return self::$instance;
    }
    
    /*
     * Initialize configuration
     */
    public function init()
    {
        $this->setStripeKeys();
        $this->setEventDates();
    }
    
    /*
     * Getter
     */
    public function get( $key )
    {
        if ( $this->$key ) {
            return $this->$key;
        }
        return null;
    }
}