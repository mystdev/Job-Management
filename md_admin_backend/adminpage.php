<?php
ob_start();
$pagetitle = 'MystDev Admin Area';
include_once('backend/includes/header.php');
@include_once('backend/lib/class_lib.php');
session_start();
@$authorization = $_SESSION['authcomplete'];
?>

<?php

    if (isset($authorization))
    {
        include('backend/includes/nav_bar.php');
        echo '<br>';
        echo @$_SESSION['success'];
        unset($_SESSION['success']);

        if (@$_GET['id'] == "add_cust")
        {
            // Add customer form          
            echo "
                  
                  <div id='addcust_form'>
                  <p class='err'>".@$_SESSION['err']."</p>
                  <form method ='post' action='backend/process/add_cust.php'>
                  <label>First Name: </label><input type='text' name='fname' value=".@$_SESSION["fname"].">
                  <label>Last Name: </label><input type='text' name='lname' value=".@$_SESSION["lname"]." >
                  <label>E-mail: </label><input type='text' name='email' value=".@$_SESSION["email"].">
                  <label>Contact Number: </label><input type='text' name='con_number' value=".@$_SESSION["con_number"].">
                  <label>Company Name: </label><input type='text' name='company' value=".@$_SESSION["company"].">
                  <label>Username: </label><input type='text' name='username' value=".@$_SESSION['username'].">
                  <label>Password: </label><input type='text' name='password'>
                  <input type='submit' value='Add customer'>
                  </form>
                  <form method='post' action='adminpage.php'>
                  <input type='submit' name='clearform' value='Clear Form Session'>
                  </form>
                  </div>
                  ";     
        }

        if (isset($_POST['clearform']))
        {
          unset($_SESSION['fname']);
          unset($_SESSION['lname']);
          unset($_SESSION['email']);
          unset($_SESSION['con_number']);
          unset($_SESSION['company']);
          unset($_SESSION['username']);
          unset($_SESSION['err']);
          header('Location:adminpage.php?id=add_cust');
        }


        if(@$_GET['id'] == "edit_cust")
        {
              $custlist = new dbQuery("SELECT * FROM mdclientauth");
              $result = $custlist->returnQuery();
              echo '<br>';
              echo @$_SESSION['success'];
              unset($_SESSION['success']);  
              // Edit Customer Select Form
              echo '<form method="post" action="adminpage.php?id=retrieve" id="select_cust">';
              echo '<select name="clientid" form="select_cust">';

              while ($cust = $result->fetch_assoc()){
                $customerid = $cust['clientauthid'];
                $fname = $cust['fname'];
                $lname = $cust['lname'];
                $company = $cust['company_name'];
                echo '<option value="'.$customerid.'">'.$fname.' '.$lname.' - '.$company.'</option>';
        }
        echo '</select>';
        echo '<input type="submit" name="retrieve_client" value="Retrieve Client">';
        echo '</form>';  
      }

      if(@$_GET['id'] == "retrieve")
      {
        $retrieveid = @$_POST['clientid'];  
        $editcust = new dbQuery("SELECT * FROM mdclientauth WHERE clientauthid = '$retrieveid'");
        $retrieve = $editcust->returnQuery();
        $edit = $retrieve->fetch_assoc();
        $id = $edit['clientauthid'];
        $fname = $edit['fname'];
        $lname = $edit['lname'];
        $contact = $edit['contact_num'];
        $email = $edit['email'];
        $company_name = $edit['company_name'];
        $user = $edit['clientauthuser'];
        // Add Customer Form
        echo "               
              <div id='addcust_form'>
              <p class='err'>".@$_SESSION['err']."</p>
              <form method ='post' action='backend/process/edit_cust.php'>
              <input type='hidden' name='id' value='$id'>
              <label>First Name: </label><input type='text' name='fname' value='$fname' size='15'><br>
              <label>Last Name: </label><input type='text' name='lname' value='$lname' size='15'><br>
              <label>E-mail: </label><input type='text' name='email' value='$email' size='35'><br>
              <label>Contact Number: </label><input type='text' name='con_number' value='$contact' size='12'><br>
              <label>Company Name: </label><input type='text' name='company' value='$company_name' size='35'><br>
              <label>Username: </label><input type='text' name='username' value='$user' size='15'><br>
              <input type='submit' name='edit' value='Edit Customer'>
              </form>
              </div>
             ";
      }

      if(@$_GET['id'] == "new_job")
      {
              $custlist = new dbQuery("SELECT * FROM mdclientauth");
              $result = $custlist->returnQuery();
              echo '<br>';
              echo @$_SESSION['success'];
              unset($_SESSION['success']);  
              // Select form for selecting a customer to add a job for
              echo '<br>Please select a client to create a new job for:';
              echo '<form method="post" action="adminpage.php?id=new_job_selected" id="select_cust">';
              echo '<select name="clientid" form="select_cust">';

              while ($cust = $result->fetch_assoc()){
                $customerid = $cust['clientauthid'];
                $fname = $cust['fname'];
                $lname = $cust['lname'];
                $company = $cust['company_name'];
                echo '<option value="'.$customerid.'">'.$fname.' '.$lname.' - '.$company.'</option>';
        }
        echo '</select>';
        echo '<input type="submit" name="retrieve_client" value="Select">';
        echo '</form>';  
      }

      if(@$_GET['id'] == "new_job_selected")
      {
        if (!isset($_SESSION['clientid']))
        {
          $_SESSION['clientid'] = $_POST['clientid'];
        }
        
        // Form for adding jobs
        echo"
              <div id='addcust_form'>
              <form method='post' action='backend/process/new_job.php' id='new_job'>
              <input type='hidden' name='clientid' value=".@$_SESSION['clientid'].">
              <label>Directory</label><input type='text' name='directory' value=".@$_SESSION['dir']."><br><br>
              <label>Description</label><textarea name='description'>".@$_SESSION['desc']."</textarea><br><br>
              <label>Estimated Job Cost</label><input type='text' name='estimated_cost' value=".@$_SESSION['estimated']."><br>
              <p class='err'>".@$_SESSION['options']."</p>
              <label>Design Package</label><br><br>
              <input type='radio' name='des_type' value='Basic Package'>Basic<br>
              <input type='radio' name='des_type' value='Business Package'>Business<br><br>
              <label>Design Hours</label><input type='text' name='des_hours' value=".@$_SESSION['des_hours']."><br><br>

              <label>Dev Package</label><br><br>
              <label>Page Count</label><input type='text' name='dev_pagecount' value=".@$_SESSION['dev_pagecount']."><br><br>
              <p class='err'>".@$_SESSION['options']."</p>
              <input type='checkbox' name='dev_contact' value='Yes'>Contact Form<br>
              <input type='checkbox' name='dev_cms' value='Yes'>CMS<br>
              <input type='checkbox' name='dev_commerce' value='Yes'>E-Commerce<br><br>
              <label>Dev Hours</label><br>
              <input type='text' name='dev_hours' value=".@$_SESSION['dev_hours']."><br><br>
              <p class='err'>".@$_SESSION['options']."</p>
              <label>Status</label> 
              <select name='status' form='new_job'>
              <option value='Preliminary Stage'>Preliminary Stage</option>
              <option value='Invoice for 25% downpayment sent'>Invoice for 25% downpayment sent</option>
              <option value='Stage 1: Design'>Stage 1: Design</option>
              <option value='Stage 1: awaiting design approval'>Stage 1: Awaiting design approval</option>
              <option value='Stage 1: Revision 1 of 2'>Stage 1: Revision 1 of 2</option>
              <option value='Stage 1: Revision 2 of 2'>Stage 1: Revision 2 of 2</option>
              <option value='Stage 1: Revision 1 of 5'>Stage 1: Revision 1 of 5</option>
              <option value='Stage 1: Revision 2 of 5'>Stage 1: Revision 2 of 5</option>
              <option value='Stage 1: Revision 3 of 5'>Stage 1: Revision 3 of 5</option>
              <option value='Stage 1: Revision 4 of 5'>Stage 1: Revision 4 of 5</option>
              <option value='Stage 1: Revision 5 of 5'>Stage 1: Revision 5 of 5</option>
              <option value='Stage 1 Completed - Invoice sent for Stage 1 Payment'>Stage 1 Completed - Invoice sent for Stage 1 Payment</option>
              <option value='Stage 2: Front End Development'>Stage 2: Front end development</option>
              <option value='Stage 2: Awaiting front end development approval'>Stage 2: Awaiting front end development approval</option>
              <option value='Stage 2: Revision 1 of 2'>Stage 2: Revision 1 of 2</option>
              <option value='Stage 2: Revision 2 of 2'>Stage 2: Revision 2 of 2</option>
              <option value='Stage 2 Completed - Invoice sent for Stage 2 Payment'>Stage 2 Completed - Invoice sent for Stage 2 Payment</option>
              <option value='Stage 3: Back End Development'>Stage 3: Back end development</option>
              <option value='Stage 3: Awaiting back end development approval'>Stage 3: Awaiting back end development approval</option>
              <option value='Stage 3: Revision 1 of 2'>Stage 3: Revision 1 of 2</option>
              <option value='Stage 3: Revision 2 of 2'>Stage 3: Revision 2 of 2</option>
              <option value='Invoice for final payment sent'>Invoice for final payment sent</option>
              <option value='Final payment cleared - Job completed'>Final payment cleared - Job complete.</option>
              </select>
              <input type='submit' name='add_job' value='Append Job'>
              </form>
              </div>
            ";
            unset($_SESSION['options']);

      }
      if(@$_GET['id'] == 'edit_job')
      {
        $custlist = new dbQuery("SELECT * FROM mdclientauth");
        $result = $custlist->returnQuery();
        echo '<br>';
        echo @$_SESSION['success'];
        unset($_SESSION['success']);  
        // Select form for selecting a customer to update a job for
        echo '<br>Please select a client to update a job for:';
        echo '<form method="post" action="adminpage.php?id=edit_job" id="select_cust">';
        echo '<select name="clientid" form="select_cust">';

          while ($cust = $result->fetch_assoc()){
            $customerid = $cust['clientauthid'];
            $fname = $cust['fname'];
            $lname = $cust['lname'];
            $company = $cust['company_name'];
            echo '<option value="'.$customerid.'">'.$fname.' '.$lname.' - '.$company.'</option>';
        }

        echo '</select>';
        echo '<input type="submit" name="retrieve_client" value="Select">';
        echo '</form>';
          if(isset($_POST['retrieve_client']))
          {
            $clientid = $_POST['clientid'];
            $joblist = new dbQuery("SELECT * FROM mdjobs WHERE clientauthid = '$clientid'");  
            $result = $joblist->returnQuery();
            echo '<br>';
            
            // Select form for selecting job to update
            echo '<br>Please select a job from the following list:';
            echo '<form method="post" action="adminpage.php?id=edit_selected" id="select_job">';
            echo '<select name="jobid" form="select_job">';

              while($job = $result->fetch_assoc())
              {
                $directory = $job['directory'];
                $jobid = $job['jobid'];
                echo '<option value="'.$jobid.'">'.$directory.'</option>';
              }
              echo '</select>';
              echo '<input type="submit" name="retrieve_job" value="Retrieve job">';
              echo '</form>';

          }
        
      }
      if(@$_GET['id'] == 'edit_selected')
      {
        $jobid = @$_POST['jobid'];
        $select_job = new dbQuery("SELECT * FROM mdjobs WHERE jobid = '$jobid'");
        $result = $select_job->returnQuery();
        while ($selected_job = $result->fetch_assoc())
        {
          $status = $selected_job['status'];
        }
        // Form displaying current job status + dropdown menu to update status
        echo '<p>Current job status: <b>'.$status.'</b>';
        echo '<form method="post" action="backend/process/update_job.php" id="update_job">';
        echo '<select name="status" form="update_job">';
        echo "
              <option value='Preliminary Stage'>Preliminary Stage</option>
              <option value='Invoice for 25% downpayment sent'>Invoice for 25% downpayment sent</option>
              <option value='Stage 1: Design'>Stage 1: Design</option>
              <option value='Stage 1: awaiting design approval'>Stage 1: Awaiting design approval</option>
              <option value='Stage 1: Revision 1 of 2'>Stage 1: Revision 1 of 2</option>
              <option value='Stage 1: Revision 2 of 2'>Stage 1: Revision 2 of 2</option>
              <option value='Stage 1: Revision 1 of 5'>Stage 1: Revision 1 of 5</option>
              <option value='Stage 1: Revision 2 of 5'>Stage 1: Revision 2 of 5</option>
              <option value='Stage 1: Revision 3 of 5'>Stage 1: Revision 3 of 5</option>
              <option value='Stage 1: Revision 4 of 5'>Stage 1: Revision 4 of 5</option>
              <option value='Stage 1: Revision 5 of 5'>Stage 1: Revision 5 of 5</option>
              <option value='Stage 1 Completed - Invoice sent for Stage 1 Payment'>Stage 1 Completed - Invoice sent for Stage 1 Payment</option>
              <option value='Stage 2: Front End Development'>Stage 2: Front end development</option>
              <option value='Stage 2: Awaiting front end development approval'>Stage 2: Awaiting front end development approval</option>
              <option value='Stage 2: Revision 1 of 2'>Stage 2: Revision 1 of 2</option>
              <option value='Stage 2: Revision 2 of 2'>Stage 2: Revision 2 of 2</option>
              <option value='Stage 2 Completed - Invoice sent for Stage 2 Payment'>Stage 2 Completed - Invoice sent for Stage 2 Payment</option>
              <option value='Stage 3: Back End Development'>Stage 3: Back end development</option>
              <option value='Stage 3: Awaiting back end development approval'>Stage 3: Awaiting back end development approval</option>
              <option value='Stage 3: Revision 1 of 2'>Stage 3: Revision 1 of 2</option>
              <option value='Stage 3: Revision 2 of 2'>Stage 3: Revision 2 of 2</option>
              <option value='Invoice for final payment sent'>Invoice for final payment sent</option>
              <option value='Final payment cleared - Job completed'>Final payment cleared - Job complete.</option>
              </select>
              ";
        echo '<input type="hidden" name="jobid" value="'.$jobid.'">';      
        echo '<input type="submit" name="update_job" value="Update Job Status">';
        echo '</form>';


      }











































    }else{
        echo "<p>Not Authorized.";  
    } 

 


?>


<?php
include_once('backend/includes/footer.php');

?>