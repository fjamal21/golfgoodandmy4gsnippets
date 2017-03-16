<?php
namespace Src\Modules\Donations\Views;

use Src\Includes\SuperClasses\AbstractView;
use Src\Config\Config;
use Src\Includes\User;

class ListView extends AbstractView
{
    /*
     * Store the website URL for convenience
     */
    protected $url;
    
    /*
     * Run
     */
    public function run()
    {
        $this->displayHeader();
        $this->displayContent();
        $this->displayFooter();
    }
    
    /*
     * Display the header
     */
    protected function displayHeader()
    {
        $config = Config::getInstance();
        $user = User::getInstance();
        
        include SRC . 'views/header.tpl.php';
        include SRC . 'Modules/Donations/includes/header.tpl.php';
    }
    
    /*
     * Display the footer
     */
    protected function displayFooter()
    {
        include SRC . 'views/footer.tpl.php';
    }
    
    /*
     * Display the content
     */
    protected function displayContent()
    {
        $donations_obj = $this->data['donations'];
        $donations = $donations_obj->getData();
        
        if ( empty( $donations ) ) {
            echo '<p>There are no donations yet.</p>';
            return;
        }
        
        echo '<p>Total Donations: $' . number_format( ( $donations_obj->getTotal() / 100 ), 2 ) . '</p><br />';
        
        $config = Config::getInstance();
        $this->url = $config->get('site_url');
        
		// Create a table to list donations.
		echo '
			<table>
				<tr>
					<th>Receipt</th>
					<th>Donation</th>
					<th>Donor</th>
					<th>Fundraiser</th>
					<th>Charity</th>
					<th>Date</th>
				<tr>
		';
	
		// Output the list of donors and donations.
		foreach ($donations AS $donation) {
		    echo $this->getRow( $donation );
		}
	
		// Close the table.
		echo '
			</table>
		';
    }
    
    /*
     * Create a single table row
     */
    protected function getRow( $donation )
    {
        $row = '';
		$row .= '<tr>';
	
		// Receipt number
		$row .= '
				<td><a href="http://' . $this->url . '/donate/receipt/' . urlencode( $donation['email'] ) . '/' . $donation['receipt_key'] . '" target="_blank">' . $donation['id'] . '</a></td>
		';
	
		// Donation amount
		$row .= '
				<td>$' . number_format( ( $donation['amount'] / 100 ), 2 ) . '</td>
		';
	
		// Donor name and email
		$row .= '
				<td>' . $donation['first_name'] . ' ' . $donation['last_name'] . ' (' . $donation['email'] . ')</td>
		';
	
		// Fundraiser name and email
		$row .= '
				<td><a href="http://' . $this->url . '/' . $donation['guid'] . '" target="_blank">' . $donation['user_first_name'] . ' ' . $donation['user_last_name'] . '</a> (' . $donation['user_email'] . ')</td>
		';
	
		// Donation date
		$row .= '
				<td>' . $donation['date_added'] . '</td>
			</tr>
		';
        
        return $row;
    }
}
