<?php
use classes\business\UserManager;
use classes\business\Validation;
session_start();
require_once 'includes/autoload.php';
include 'includes/header.php';
?>
<center>
<div class="container">
<div class='jumbotron'>    
<h1><a href="<?=$siteroot?>home.php"><img src="<?=$logo?>" style="width:55px; height:35px"></a>
ABC Job Portal
</h1>
<div> 
    <p style='text-align: justify;'>
    Tired searching for a job? Feeling helpless? Tired of waiting for a response after applying on those job portals? We are there to help you out.
    You has come up with an amazing job portal where candidates can apply for desired jobs and even employers can post their requirements. With two separate registrations, this portal allows both candidates and the employers, an ease in searching for the suitable match for each other. It allows the employers to send an email or sms to the candidates they feel are fit for the vacancy they have.
    </p>
    
    <h2>Features for Candidates:</h2>
    <p style='text-align: justify;'>
    Candidates can search for a job according to their preferred city.
    Candidates can send their resumes to the companies which are located in their preferred cities.
    Candidates can fill the bio data form which is designed for them in the portal with an attachment of their resume.
    Candidates shall receive an email or sms if they are being short listed for the interview by an employer.
    </p>
    
    <h2>Features for Employers:</h2>
    <p style='text-align: justify;'>
    Employers can find suitable candidates by searching with the desired key words for the vacancy.
    Employers can post the vacancies by filling up a form designed for the same. They can mention the job description and salary offered in that.
    Employers will be allowed to send out an email or sms to those candidates directly who found to fit the criteria of the job opening.
    </p>
</div>
</div>
</div>
</center>
<?php
include 'includes/footer.php';