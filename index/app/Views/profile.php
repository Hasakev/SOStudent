<div class="container" id="main">
    <h2> User Profile </h2>
    Username: <?= $username ?> <a href="<?php echo base_url()?>changeusername">Change</a>
    <br>
    Name: <?= $first ?> <?= $last ?> <a href="<?php echo base_url()?>changename">Change</a>
    <br>
    Email: <?= $email ?> 
    <br>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <div >Email Verification Status:  
        <br>
        <?php
        $model = model('App\Models\User_model'); 
        if (! ($model->verification_status($email))) { ?>
        <div id="form">
            <input id="checki" placeholder="Enter Code" name="code">
            <button id="checkb" onclick="sendRequest();">Verify</button> 
        </div>  
        <?php } else {
            print("Verified");
        }?>

        <div id="ajaxResponse"></div>
    </div>
	<script>
		function sendRequest() {
			var xhttp = new XMLHttpRequest();
            var str = document.getElementById("checki").value;
            if (str == "") {
                str = "empty";
            }
			xhttp.open("GET", "<?php echo base_url('verify'); ?>/" + str, true);            
            // setting "X-Requested-With" as "XMLHTTPRequest" in header is important
            // otherwise the request->isAJAX() does not work.
			xhttp.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
			xhttp.send();
            xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {  
                    document.getElementById("ajaxResponse").innerHTML = this.responseText;
                    if (document.getElementById("ajaxResponse").innerHTML == "Verified") {
                        document.getElementById("form").remove();
                    }                                                  
				}
			};
		} 
        sendRequest();  
	</script>
    <br>
    <a href="<?php echo base_url()?>upload">Upload Profile Picture</a>
    <br>
    <a href="<?php echo base_url()?>changepass">Change Password</a>
</div>
