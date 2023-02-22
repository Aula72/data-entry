<!doctype html>
<html lang="en">
<?php 
 $t= $_SERVER['HTTP_HOST'];
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/bootstrap.css">
 
  <title>Import CSV File into MySQL using PHP</title>
 
  <style>
    .custom-file-input.selected:lang(en)::after {
      content: "" !important;
    }
 
    .custom-file {
      overflow: hidden;
    }
 
    .custom-file-input {
      white-space: nowrap;
    }
  </style>
</head>
 
<body>
 
  <div class="container">
    <h2>Upload Files</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <!-- <div class="input-group mb-3">
            <input type="text" name="date" class="form-control" placeholder="Enter date "id="">
</div> -->
      <div class="input-group mb-3">
        <div class="custom-file">
          <input type="file" class="form-control" id="customFileInput" aria-describedby="customFileInput" name="file">
          <label class="custom-file-label" for="customFileInput">Select file</label>
        </div>
        <div class="input-group-append">
           <input type="submit" name="submit" value="Upload" class="btn btn-primary">
        </div>
      </div>
  </form>
  </div>
    <table style="margin:auto;" class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody id="people"></tbody>
    </table>
</body>
 
</html>

<script>
  let x = new XMLHttpRequest()

  x.open("get", `http://<?php echo $t?>/api.php?date`, true)
  x.onload = function(){
    let dates = JSON.parse(this.responseText)
    let p = ''
    let c = 1
    for(let y of dates.dates){
      p += `<tr>
      <td>${c}</td>
      <td>${y.name}</td>
      <tr>`
      c++;
    }
    document.getElementById("people").innerHTML = p
  }
  x.setRequestHeader("content-type","application/json");
  x.setRequestHeader("auth", "2301921201-eoriopew")
  x.setRequestHeader("origin", "localhost:9000")
  x.send()
</script>