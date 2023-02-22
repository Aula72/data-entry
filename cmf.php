<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Send Money</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>
<body>
	<div class="container">
  <h1>Send Money</h1>
  <form id="send">
  	
  	<div class="mb-3">
  		<label for="sel1" class="form-label">Select Network</label>
    <select class="form-select" id="sel1" name="sellist1">
      <option value="1">MTN</option>
      <option>Airtel</option>
      
    </select>
  	</div>
  	<div class="mb-3">
  		<label for="pwd" class="form-label">Phone Number</label>
    <input type="tel" class="form-control" id="phone" placeholder="Phone Number" name="pswd">
  	</div>
  	<div class="mb-3">
  		<label for="pwd" class="form-label">Amount</label>
    <input type="number" class="form-control" id="amt" placeholder="Amount" name="pswd">
  	</div>
  	<div class="mb-3">
  		<label for="pwd" class="form-label">Password</label>
    <input type="passord" class="form-control" id="pwd" placeholder="Password" name="pswd">
  	</div>
  	<button type="submit" class="btn btn-primary">Submit</button>

  	<?php 
  	// echo password_hash("g!2tymnbb", PASSWORD_DEFAULT); 
  	// password_verify(password, hash)
  	?>
  </form>
</div>
</body>

<script type="text/javascript">
	$("#send").submit(e=>{
		e.preventDefault()
		let net =  $("#sel1").val();
		let phone = $("#phone").val();
		let pass = $("#psw").val();
		let amt = $("#amt").val();
		let data = {
			pass,
			net,
			phone
		}

		$.ajax({
		type: "post",
		url: `https://mfiss.online/`,
		headers:{
			"Content-Type":"application/json"
		},
		dataType: "json",
		success: function (response) {
			// console.log(response)
			constants.utype = response.user.user_type_id
			constants.mail = response.user.mail
		}
	});
	})
</script>
</html>