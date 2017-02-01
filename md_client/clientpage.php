<?php
ob_start();
$pagetitle = "Client Page";
include_once('backend/includes/header.php');
@include_once('backend/lib/class_lib.php');

session_start();

@$user = $_SESSION['user'];
@$id = $_SESSION['id'];
@$fname = $_SESSION['fname'];
?>

<?php

    if (isset($user) && isset($id) && isset($fname))
    {
    	include_once('backend/includes/nav_bar.php');   
    	// Start of table for displaying jobs.
    	echo '<table>';
    	// Table of jobs Table Headers
    	echo '
                <tr>
                <th>Job ID</th>
                <th>Status</th>
                <th>Job Description</th>
                <th>Contract</th>
                <th>Chosen Layout*</th>
                <th>Temp Site**</th>
                </tr>';
    	
    	$jobquery = new dbQuery ("SELECT * FROM mdjobs WHERE clientauthid = '$id'");
    	$jobs = $jobquery->returnQuery();
    	while ($results = $jobs->fetch_assoc())
    	{
    		$id = $results['jobid'];
    		$desc = $results['description'];
    		$status = $results['status'];
    		$dir = $results['directory'];
    	// Row of data for table of jobs.
    		echo '<tr>';
    		echo '<td>';
    		echo $id;
    		echo '</td>';
    		echo '<td>';
    		echo $status;
    		echo '</td>';
    		echo '<td>';
    		echo $desc;
    		echo '</td>';
    		echo '<td>';
    		echo '<a href="../admin/clients/'.$user.'/'.$dir.'/contract/contract.pdf">Click Here</a>';
    		echo '</td>';
    		echo '<td>';
    		echo '<a href="../admin/clients/'.$user.'/'.$dir.'/layout/layout.jpg">Click Here</a>';
    		echo '</td>';
            echo '<td>';
            echo '<a href="../../../temp/'.$user.'">Click Here</a>';
            echo '</td>';
            echo '</tr>';
    		
    	}
		// End of table of jobs

		echo '</table>';
		// Letting clients know they can only see layout when in stage 2 or higher.
		echo '<p>* This will only be available if the job status is in Stage 2 or higher.</p>';
        echo '<p>** This will only be available once stage 2 & 3 are complete</p>';
        echo'<h1>Need to contact us?</h1><p>Feel free to e-mail <a href="mailto:luke@mystdev.com">luke@mystdev.com</a> with any questions or queries.</p>
             <p>Mobile: 0411 716 762</p>
             <p>Skype: <a href="skype:mystdev">mystdev</a></p>';
    	    }else{
    	// Error when trying to access site without successfully logging in.   	
        echo "<p>Not Authorized.";  
    } 

 


?>


<?php
include_once('backend/includes/footer.php');
?>