<?php require_once("Includes/DB.php"); ?>
<?php
function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}
function CheckUserNameExistsOrNot($UserName){
  global $ConnectingDB;
  $sql    = "SELECT Name FROM Staff WHERE Name=:pName";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':pName',$UserName);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}
function Login_Attempt($UserName,$Password){
  global $ConnectingDB;
  $sql = "SELECT * FROM Staff WHERE Name=:pName AND password=:passWord LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':pName',$UserName);
  $stmt->bindValue(':passWord',$Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account=$stmt->fetch();
  }else {
    return null;
  }
}
function Confirm_Login(){
if (isset($_SESSION["UserId"])) {
  return true;
}  else {
  $_SESSION["ErrorMessage"]="Login Required !";
  Redirect_to("Login.php");
}
}

function TotalPosts1(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Posts";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalPosts1=array_shift($TotalRows);
  echo $TotalPosts1;
}

function TotalCategories(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Category";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalCategories=array_shift($TotalRows);
  echo $TotalCategories;
}

function TotalDepartments(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Department";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalDepartments=array_shift($TotalRows);
  echo $TotalDepartments;
}

function TotalAdmins(){

  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Staff";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalAdmins=array_shift($TotalRows);
  echo $TotalAdmins;

}

function TotalComments(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Comments";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalComments=array_shift($TotalRows);
  echo $TotalComments;
}

function ApproveCommentsAccordingtoPost($PostId){
  global $ConnectingDB;
  $sqlApprove = "SELECT COUNT(*) FROM Comments WHERE PostID='$PostId' AND status='ON'";
  $stmtApprove =$ConnectingDB->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}

function DisApproveCommentsAccordingtoPost($PostId){
  global $ConnectingDB;
  $sqlDisApprove = "SELECT COUNT(*) FROM Comment WHERE PostID='$PostId' AND status='OFF'";
  $stmtDisApprove =$ConnectingDB->query($sqlDisApprove);
  $RowsTotal = $stmtDisApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}
 ?>
