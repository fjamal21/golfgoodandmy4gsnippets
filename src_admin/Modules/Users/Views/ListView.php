<?php
namespace Src\Modules\Users\Views;

use Src\Includes\SuperClasses\AbstractView;
use Src\Config\Config;
use Src\Includes\User;

class ListView extends AbstractView
{
    /*
     * Store the site url for convenience
     */
    private $url;
    
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
        include SRC . 'Modules/Users/includes/header.tpl.php';
    }
    
    /*
     * Display the footer
     */
    protected function displayFooter()
    {
        include SRC . 'views/footer.tpl.php';
    }
    
    /*
     * Display the list
     */
    protected function displayContent()
    {
        $config = Config::getInstance();
        $user = User::getInstance();
        $this->url = $config->get('site_url');
        
        //$module_name = 'users';

        $users_obj = $this->data['users'];
        $users = $users_obj->getData();
        
        if ( empty( $users ) ) {
            echo '<p>There are no users yet.</p>';
            return;
        }
        
        echo '<p>Total Users: ' . $users_obj->count() . '</p><br />';
        
		echo '
			<table>
				<tr>
					<th>Profile Page</th>
					<th>Name</th>
					<th>Email</th>
					<th>Status</th>
					<th>Access Level</th>
					<th>Registration Date</th>
				<tr>
		';
	
		// Output the list of users.
		foreach ($users as $user) {
            echo $this->getRow( $user );
        }
        
		// Close the table.
		echo '
			</table>
		';
    }
    
    /*
     * Build a table row
     */
    protected function getRow( $row )
    {
        $tr = '
        	<tr>
        ';

        // guid
        $tr .= '
        		<td><a href="http://' . $this->url . '/' . $row['guid'] . '" target="_blank">' . $row['guid'] . '</td>
        ';

        // Name
        $tr .= '
        		<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
        ';

        // Email
        $tr .= '
        		<td>' . $row['email'] . '</td>
        ';
        
        // Status
        $tr .= '
        		<td>' . $this->getStatus( $row['status'] ) . '</td>
        ';

        // Level
        $tr .= '
        		<td>' . $row['level'] . '</td>
        ';
        
        // Registration date
        $tr .= '
        		<td>' . $row['date_added'] . '</td>
        	</tr>
        ';
        
        return $tr;
    }
    
    /*
     * Set the status
     */
    protected function getStatus( $number )
    {
        switch ( $number ) {
            case 0:
                return 'Incomplete';
            case 1:
                return 'Complete';
            case 2:
                return 'Suspended';
            case 3:
                return 'Deleted';
        }
    }
    
}
