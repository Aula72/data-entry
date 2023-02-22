<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Entry</title>
    <link href="assets/bootstrap.css" rel="stylesheet" >
    <script src="assets/jquery.js"></script>
    <script src="assets/jquery-ui.js"></script>
    <?php 
        $url = $_SERVER["HTTP_HOST"];
    ?>
</head>
<body>
    
    <div class="container-fluid">
        <h1 class="text-center">Data Entry</h1>
        <!-- <div class="alert alert-success" id="warning"> -->
  <!-- strong>Success!</strong> Indicates a successful or positive action.
</div> -->
        <div class="row">
            <div class="col-lg-8">
                <form  id="addItem">
                    <div class="mb-3">
                    <select class="form-select" id="dates" onchange="change_date(this.value)" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <select class="form-select" id="location" onchange="change_loc(this.value)" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    </div>
                    <div class="mb-5">
                        <div class="ui-widget">
                            <label for=""></label>
                        <input class="form-control form-control-sm" id="nums" max-length="8" type="text" placeholder="Number plate" 
                        aria-required="true" required="" aria-label=".form-control-lg example" required>
                        </div>
                    
                    
                    </div>
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                            <button type="submit" class="btn btn-block btn-danger">Send</button>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    Records Added Now <span class="text-right" id="sdv">0</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
            <div class="col-lg-4">
                <div class="list-group">
                    <div class="list-group-item">
                        <button class="btn btn-sm btn-primary" onclick="add_date()">Add Date</button>
                    </div>
                    <div class="list-group-item">
                    <button class="btn btn-sm btn-secondary" onclick="add_location()">Add Location</button>
                    </div>
                    <div class="list-group-item">
                        <a href="/files.php" class="btn btn-warning btn-sm">Upload CSV</a>
                    </div>
                    <!-- <div class="list-group-item"></div>
                    <div class="list-group-item"></div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                
                
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>NUMBER</th>
                    <th>LOCATION</th>
                    <th>DATE</th>
                    <th>
                        <select name="" class="form-control" id="street"></select>
                    </th>
                    <th>
                        <select name="" class="form-control" id="day"></select>
                    </th>
                    
                    <th>
                        <select name="" onchange="record_count(this.value)" class="form-control" id="records">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="2000">2000</option>
                            <option value="5000">5000</option>
                            <option value="10000">10000</option>
                        </select>
                    </th>
                </tr>
                </thead>
                <tbody id="people"></tbody>
            </table>
            </div>
            <div class="col-lg-2">
                <h5>Stats</h5>
                <div class="row mb-3">
                    <div class="col">Number</div>
                    <div class="col" id="np">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Unique No</div>
                    <div class="col" id="un">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Repeating No.</div>
                    <div class="col" id="rp">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Added Today</div>
                    <div class="col" id="tdf">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Ratio</div>
                    <div class="col" id="rt">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Dates</div>
                    <div class="col" id="dt">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Streets</div>
                    <div class="col" id="st">loading...</div>
                </div>
                <div class="row mb-3">
                    <div class="col">Street Covered this date</div>
                    <div class="col" id="tyy">loading...</div>
                </div>
                <div class="row mb-3">
                    <h5 class="mb-3">Finished Street</h5>
                    <ul class="list-group" id="complete"></ul>
                </div>
            </div>
        </div>
    </div>
        
    <script>
        const headers = {"content-type":"application/json"}
        const base_url = "<?php echo $url; ?>";
        const api_url = `http://${base_url}/api.php`;
        
        
    </script>
    <script src="assets/js.js"></script>
    <script src="assets/select2.js"></script>
    <script src="assets/bootstrap.js"></script>
</body>
<style>
    #nums{
        text-transform:uppercase;
    }
    body{
        /* background-color:#000;
        color: #fff; */
    }
    /* li{
        list-style: none;
        margin:5px;
        border: 5px;
        z-index: 1;
        /* position: relative; */
    } */
</style>
</html>