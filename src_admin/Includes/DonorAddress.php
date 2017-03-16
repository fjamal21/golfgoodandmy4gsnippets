<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\DB;

class DonorAddress extends AbstractCrud
{
    /*
     * Data
     */
    protected $id;
    protected $donor_id;
    protected $address;
    protected $city;
    protected $region;
    protected $country;
    protected $postal_code;
    protected $telephone;
    protected $date_added;
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->donor_id || ! $this->address || ! $this->city || ! $this->region || ! $this->country || ! $this->postal_code || ! $this->telephone ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO donor_addresses (
            donor_id,
            address,
            city,
            region,
            country,
            postal_code,
            telephone,
            date_added
        ) VALUES (
            :donor_id,
            :address,
            :city,
            :region,
            :country,
            :postal_code,
            :telephone,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':donor_id', $this->donor_id);
        $sh->bindParam(':address', $this->address);
        $sh->bindParam(':city', $this->city);
        $sh->bindParam(':region', $this->region);
        $sh->bindParam(':country', $this->country);
        $sh->bindParam(':postal_code', $this->postal_code);
        $sh->bindParam(':telephone', $this->telephone);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
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
        if ( ! $this->donor_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM donor_addresses WHERE donor_id=:donor_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':donor_id', $this->donor_id);
        
        $sh->execute();
        
        if ( ! $sh->rowCount() == 1 ) {
            return false;
        }
        $r = $sh->fetch(\PDO::FETCH_ASSOC);
        if ( $r ) {
            foreach ( $r as $k => $v ) {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    
    /*
     * Update
     */
    public function update()
    {
        
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        
    }
}
