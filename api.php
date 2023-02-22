<?php 
include_once "db.php";
header("Content-Type: application/json");
header("Access-Controll-Allow-Origin: */*");
$ty = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents("php://input"), true);
function lo_name($id){
    global $conn;
    $u = $conn->prepare("select * from locs where id=:id");
    $u->execute([":id"=>$id]);
    $y = $u->fetch();
    return $y["name"];
}

function date_name($id){
    global $conn;

    $u = $conn->prepare("select * from dates where id=:id");
    $u->execute([":id"=>$id]);
    $y = $u->fetch();
    return $y["name"];
}

switch($ty){
    case "POST":
        if(isset($_GET["location"])){
            $ty = trim(strtoupper($data['name']));
            $conn->exec("insert into locs(name) value('$ty')");
            $msg["message"]="Location added...";
        }else if(isset($_GET["date"])){
            $ty = trim($data['name']);
            $conn->exec("insert into dates(name) value('$ty')");
            $msg["message"]="Location added...";
        }else{
            
            $ty = trim(strtoupper($data['name']));
            $lo = lo_name($data["location"]);
            $dt = date_name($data["date"]);
            //die(json_encode(["simo"=>1]));
            if($ty!="" && $lo != "" && $dt != ""){
                $conn->exec("insert into nums(names, loc_id, dates_id) value('$ty', '$lo', '$dt')");
                $msg["message"]="Recorded added...";

                $ty = $conn->prepare("select count(*) as ns from nums where loc_id=:l and dates_id=:d");
                $ty->execute([":l"=>$lo, ":d"=>$dt]);
                $u = $ty->fetch();
                $msg["nums"]  = $u["ns"];
            }else{
                $msg["message"]="All fields are required...";
            }
        }
        break;
    case "GET":
        if(isset($_GET["location"])){
            $loc3 = $_GET['location'];
            $u = $conn->prepare("select * from locs order by name asc");
            $u->execute();

            $msg["locations"] = [];
            foreach($u->fetchAll(PDO::FETCH_ASSOC) as $row){
                array_push($msg["locations"], $row);
            }

        }else if(isset($_GET["search"])){
            // $d  = $_GET["d"];
            // $g  = $_GET["l"];
            $u = $conn->prepare("select distinct(names) from nums where  names  like :nm order by names limit 10");

            $u->execute([":nm"=>'%'.$_GET["search"].'%']);

            $msg["nums"] = [];
            foreach($u->fetchAll(PDO::FETCH_ASSOC) as $row){
                array_push($msg["nums"], $row);
            }
        }else if(isset($_GET["date"])){
            $u = $conn->prepare("select * from dates order by id desc");
            $u->execute();

            $msg["dates"] = [];
            foreach($u->fetchAll(PDO::FETCH_ASSOC) as $row){
                array_push($msg["dates"], $row);
            }
        }else if(isset($_GET["select-street"])){
            $f = $_GET["select-street"];
            $m = $conn->prepare("select distinct(names) from nums where dates_id=$f");
        }else if(isset($_GET["stats"])){
            $u = $conn->prepare("select count(*) as num from dates");
            $u->execute();
            $u = $u->fetch();
            $msg["dates"] = $u["num"];

            $u = $conn->prepare("select count(*) as num, count(distinct(names)) as names from nums");
            $u->execute();
            $u = $u->fetch();
            $msg["number"] = $u["num"];
            $msg["diff_name"] = $u["names"];

            $u = $conn->prepare("select count(*) as num from locs");
            $u->execute();
            $u = $u->fetch();
            $msg["streets"] = $u["num"];
            $d=date('Y-m-d');
            $y = $conn->prepare("select count(*) as b from nums where cast(created_at as Date) ='$d'");
            $y->execute();
            $m = $y->fetch();
            $msg["today"] = $m["b"];

            //date
            $do = date_name($_GET["d"]);
            $msg["now"] = $do;
            $t = $conn->prepare("select count(distinct(loc_id)) as dify from nums where dates_id='$do'");
            $t->execute();
            $ro = $t->fetch();

            $msg["tyy"] = $ro["dify"];

            $t = $conn->prepare("select distinct(loc_id) as dify from nums where dates_id='$do' order by loc_id");
            $t->execute();

            $msg["complete"] = [];
            foreach($t->fetchAll(PDO::FETCH_ASSOC) as $row){
                array_push($msg["complete"], $row["dify"]);
            }

        }else{
            $lim = isset($_GET['lim'])?$_GET['lim']:20;
            $u = $conn->prepare("select * from nums order by id desc limit $lim");

            $u->execute();

            $msg["nums"] = [];
            foreach($u->fetchAll(PDO::FETCH_ASSOC) as $row){
                array_push($msg["nums"], 
                [
                    "id"=>$row["id"],
                    "name"=>$row["names"],
                    "date"=>$row["dates_id"],
                    "location"=>$row["loc_id"],
                    "created_at"=>$row["created_at"]
                ]
            );
            }
        }
        break;
    case "PUT":
        // die(json_encode($data));
        $t = $conn->prepare("update nums set names=:n where id=:i");
        $t->execute([":n"=>trim(strtoupper($data["name"])), ":i"=>$_GET["id"]]);
        $msg["message"]="Record updated...";
        break;
    case "DELETE":
        $t = $conn->prepare("delete from nums where id=:id");
        $t->execute([":id"=>$_GET["id"]]);
        $msg["message"]  ="Delete successfully";
        break;
    default:
        $msg["message"]= "Errors";
        break;
}
// $msg["date"] = date('d-m-Y H:i:s');
echo json_encode($msg);

