<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\DB;
use Src\Includes\User;
use Src\Includes\UserImages;
use Src\Includes\UserCharities;

class UserProfile extends AbstractCrud
{
    /*
     * Store original values
     */
    protected $original = array();
    
    /*
     * Data
     */
    protected $id;
    protected $user_id;
    protected $first_name;
    protected $last_name;
    protected $goal_holes;
    protected $goal_raise;
    protected $goal_quip;
    protected $current_holes;
    protected $current_raise;
    protected $message;
    protected $donate_message;
    protected $video;
    protected $fundraiser_type;
    protected $date_added;
    protected $date_modified;
   
    
    /*
     * Guid, user charities
     */
    protected $guid;
    protected $user_charities;
    
    /*
     * User Images, uploads directory
     */
    protected $user_images;
    protected $directory;
    
    /*
     * Constructor sets nulls
     */
    public function __construct()
    {
        $this->id = null;
        $this->user_id = null;
        $this->first_name = null; 
        $this->last_name = null;
        $this->goal_holes = 100;
        $this->goal_raise = 180000;
        $this->goal_quip = null;
        $this->current_holes = 0;
        $this->current_raise = 0;
        $this->message = null;
        $this->donate_message = null;
        $this->video = null;
        $fundraiser_type = null;
        $this->date_added = null;
        $this->date_modified = null;
       
        
        $this->guid = null;
        $this->user_charities = new UserCharities;
        
        $this->user_images = new UserImages;
        $directory = null;
    }
    
    /*
     * Get an image
     */
    public function getImage( $type = 'profile' )
    {
        if ( $this->user_images ) {
            return $this->user_images->get( $type );
        }
        return null;
    }
    
    /*
     * Get the fundraiser type
     */
    public function getFundraiserTitle()
    {
        $title = 'Fundraiser';
        if ( $this->fundraiser_type ) {
            switch ( $this->fundraiser_type ) {
                case 'advocate':
                    $title = 'Champion';
                    break;
                case 'champion':
                    $title = 'Champion';
                    break;
                case 'fundraiser':
                default:
                    $title = 'Fundraiser';
                    break;
            }
        }
        return $title;
    }
    
    /*
     * Set the user id
     */
    public function setUserId( $user_id = null )
    {
        if ( ! $user_id || ! $this->user_id ) {
            $user = User::getInstance();
            $this->user_id = $user->get('id');
            return;
        }
        $this->user_id = $user_id;
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->user_id ) {
            $this->setUserId();
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO user_profiles (
            user_id,
            first_name,
            last_name,
            goal_holes,
            goal_raise,
            goal_quip,
            current_holes,
            current_raise,
            message,
            donate_message,
            video,
            date_added
            
        ) VALUES (
            :user_id,
            :first_name,
            :last_name,
            :goal_holes,
            :goal_raise,
            :goal_quip,
            :current_holes,
            :current_raise,
            :message,
            :donate_message,
            :video,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id);
        $sh->bindParam(':first_name', $this->first_name);
        $sh->bindParam(':last_name', $this->last_name);
        $sh->bindParam(':goal_holes', $this->goal_holes);
        $sh->bindParam(':goal_raise', $this->goal_raise);
        $sh->bindParam(':goal_quip', $this->goal_quip);
        $sh->bindParam(':current_holes', $this->current_holes);
        $sh->bindParam(':current_raise', $this->current_raise);
        $sh->bindParam(':message', $this->message);
        $sh->bindParam(':donate_message', $this->donate_message);
        $sh->bindParam(':video', $this->video);
        
       if ( $sh->execute() ) {
           $this->id = $pdo->lastInsertId();
           return true;
       }
       
       return false;
    }
    
    /*
     * Read
     */
    public function read()
    {
        if ( ! $this->user_id ) {
            $this->setUserId();
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT up.*, u.directory FROM user_profiles AS up LEFT JOIN users AS u ON u.id=up.user_id  WHERE user_id=:user_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id);
        $sh->execute();
        
        $this->original = array();
        if ( $sh->rowCount() == 1 ) {
            $this->original = $sh->fetch(\PDO::FETCH_ASSOC);
        }
        if ( ! empty( $this->original ) ) {
            foreach ( $this->original as $k => $v ) {
                $this->$k = $v;
            }
            
            $this->user_charities->set('user_id', $this->user_id );
            $this->user_charities->read();

            $this->user_images->set('user_id', $this->user_id );
            $this->user_images->read();
            
            return true;
        }
        return false;
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->user_id ) {
            $this->setUserId();
        }
        //echo 'User Id: ' . $this->user_id . '<br />';
        
        if ( ! $this->isChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE user_profiles SET
            first_name=:first_name,
            last_name=:last_name,
            goal_holes=:goal_holes,
            goal_raise=:goal_raise,
            goal_quip=:goal_quip,
            current_holes=:current_holes,
            current_raise=:current_raise,
            message=:message,
            donate_message=:donate_message,
            video=:video
        WHERE user_id=:user_id
        LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':first_name', $this->first_name);
        $sh->bindParam(':last_name', $this->last_name);
        $sh->bindParam(':goal_holes', $this->goal_holes);
        $sh->bindParam(':goal_raise', $this->goal_raise);
        $sh->bindParam(':goal_quip', $this->goal_quip);
        $sh->bindParam(':current_holes', $this->current_holes);
        $sh->bindParam(':current_raise', $this->current_raise);
        $sh->bindParam(':message', $this->message);
        $sh->bindParam(':donate_message', $this->donate_message);
        $sh->bindParam(':video', $this->video);
        $sh->bindParam(':user_id', $this->user_id);
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
           return true;
        }
       
       return false;
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        return false;
    }
    
    /*
     * Add a donation amount
     */
    public function addDonation( $amount )
    {
        $this->current_raise += $amount;
    }
    
    /*
     * Check for the fundraiser type
     */
    public function hasRole( $role )
    {
        if ( $role == $this->fundraiser_type ) {
            return true;
        }
        return false;
    }
    
    /*
     * Check if values have changed
     */
    protected function isChanged()
    {
        foreach ( $this->original as $k => $v ) {
            if ( $this->$k != $v ) {
                return true;
            }
        }
        return false;
    }
    
    /*
     * Score (add, subtract)
     */
    public function addScore( $score )
    {
        $this->current_holes += $score;
    }
    public function minusScore( $score )
    {
        $this->current_holes -= $score;
        if ( $this->current_holes < 0 ) {
            $this->current_holes = 0;
        }
    }
}
