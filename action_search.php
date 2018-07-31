<?php

if(isset($_POST["Search"])){
  session_start();
  $_SESSION["date"] = "";
  $_SESSION["timeslot"] =  "";
  $_SESSION["district"] =  "";
  $_SESSION["specialization"] = "";
  if(isset($_POST["date"])){
    $_SESSION["date"] = $_POST["date"];
  }
  if(isset($_POST["timeslot"])){
    if($_POST["timeslot"]=="All"){
      $_SESSION["timeslot"] = "";
    }
    else{
      $_SESSION["timeslot"] = $_POST["timeslot"];
    }
  }
  if(isset($_POST["specialization"])){
    if($_POST["specialization"]=="All"){
      $_SESSION["specialization"] = "";
    }
    else{
      $_SESSION["specialization"] = $_POST["specialization"];
    }
  }
  if(isset($_POST["district"])){
    if($_POST["district"]=="All"){
      $_SESSION["district"] = "";
    }
    else{
      $_SESSION["district"] = $_POST["district"];
    }
  }
  header("Location:result");
}

if(isset($_GET["Search"])&&!empty($_GET["Search"])){
  session_start();
  $_SESSION["date"] = "";
  $_SESSION["timeslot"] =  "";
  $_SESSION["district"] =  "";
  $_SESSION["specialization"] = "";
  if(isset($_GET["date"])){
    $_SESSION["date"] = $_GET["date"];
  }
  if(isset($_GET["timeslot"])){
    if($_GET["timeslot"]=="All"){
      $_SESSION["timeslot"] = "";
    }
    else{
      $_SESSION["timeslot"] = $_GET["timeslot"];
    }
  }
  if(isset($_GET["specialization"])){
    if($_GET["specialization"]=="All"){
      $_SESSION["specialization"] = "";
    }
    else{
      $_SESSION["specialization"] = $_GET["specialization"];
    }
  }
  if(isset($_GET["district"])){
    if($_GET["district"]=="All"){
      $_SESSION["district"] = "";
    }
    else{
      $_SESSION["district"] = $_GET["district"];
    }
  }
  header("Location:result");
}

?>
