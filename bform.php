<?php
  session_start();
  
  error_reporting(0);
  //Server Credentials
  $MyServerName = "localhost";
  $MyUserName = "root";
  $MyPassword = "";
  //Database
  $MyDBName = 'chem_glasswares';
  $MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
  
  include("verify.php");
?>
<html>
<head>
  <title>Home: UPB Glasswares and Chemicals Inventory</title>
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <?php 'loading head';include("head.php"); ?>
  <script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>
  <link rel="stylesheet" href="datatables/DataTables/css/dataTables.bootstrap4.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatables/DataTables/js/dataTables.bootstrap4.js"></script>
</head>
<body  style="z-index: -10000:">
  <div class="container">
        <h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Borrower's Form</h1>
        <p class="text-center">Required fields are indicated by *</p>
        <div class="container" style="padding: 20px; margin-bottom: 50px; border-radius: 10px; background-color: #edeef2; border:2px solid #dbdbdb;">
          <form  action="/bprocess.php" target="_self" method="POST">
          <div class="form-group">
            <label for="borrowerid">Borrower ID: </label>
            <input class="form-control" id="borrowerid" readonly="readonly" value="insert php increment" />
          </div>
          
          <label class="try" for="members">Group Members: </label>
          <div class="row grpmem" style="padding: 5px; margin: auto;">
            <div class="col-md-4">
              <input type="text" name="sid[]" class="form-control" placeholder="Student ID*" required="true">
            </div>
            <div class="col-md-4">
              <input type="text" name="lname[]" class="form-control" placeholder="Last Name*" required="true">
            </div>
            <div class="col-md-3">
              <input type="text" name="fname[]" class="form-control" placeholder="First Name*" required="true">
            </div>
            <button class="btn btn-danger remover" form="" style="cursor: pointer; visibility: hidden; text-align: right;"><i class="fas fa-minus"></i></button>
          </div>
          <center><button type="button" class="btn btn-info" id="add-row" name="add-row" onmouseover="" style="cursor: pointer; margin-top: 20px;">Add Member</button></center>
          
          <label for="instruct">Instructor's Info:</label>
          <div class="row" id="instruct" style="margin: auto; padding: 5px;">
            <div class="col-md-6">
              <input type="text" id="prof" class="form-control" placeholder="Name of Professor">
            </div>
            <div class="col-md-5">
              <input type="text" id="subj" class="form-control" placeholder="Name of Subject*" required="true">
            </div>
          </div>

          <label for="item">Items:</label>
          <div class="row try2">
              <div class="col-md-7"><center>Item</center></div>
              <div class="col-md-4"><center>Quantity</center></div>
          </div>
          <div class="row grpit" style="padding: 5px; margin: auto;">
            <div class="col-md-7">
              <input type="text" name="it[]" class="form-control" placeholder="Chemical/Equipment*" required="true">
            </div>
            <div class="col-md-2">
              <input type="text" name="amount[]" class="form-control" placeholder="Amount*" required="true">
            </div>
            /<div class="col-md-1">
              <input type="text" class="form-control" placeholder="Max" readonly="readonly">
            </div>
            <div class="col-md-1">
              <input type="text" class="form-control" placeholder="Unit" readonly="readonly">
            </div>
            <button class="btn btn-danger remover2" form="" style="float:right; cursor: pointer; visibility: hidden;"><i class="fas fa-minus"></i></button>
          </div>
          <center><button type="button" class="btn btn-info" id="add-item" name="add-item" onmouseover="" style="cursor: pointer; margin-top: 20px; text-align: right;">Add Item</button></center>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#myModal" style="margin: auto; margin-top: 60px; cursor: pointer;">
            Confirm
          </button>

          <!-- Modal -->
          <div class="modal" id="myModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered w3-animate-bottom" style="max-width: 1000px !important;">
              <div class="modal-content" style="border-radius: 10px; padding: 20px;">
                <div class="modal-header" style="background-color: white; color: black; text-align: center;">
                    <h3 style="padding: 8px;"><strong>Confirm Credentials</strong></h3>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer" style="background-color: white; color: black;">
                  <div class="text-center" style="float: left; text-align: left;">
                    <p>Are you sure you want to submit?</p>
                  </div>
                  <span style="width: 20px;"></span>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button submit" class="btn btn-success" style="cursor: pointer;">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>

  </div>
  <?php include("footer.php") ?>
</body>
      
</html>

<script type="text/javascript">
  jQuery(function($){
    var $button = $('#add-row'),
        $row = $('.grpmem').clone();
    var $try=$('.try');
    $button.click(function(){
        $row.clone().insertAfter( $try );
        $('.remover').css({
          visibility: ''
        });
        $('.remover').first().css({
          visibility: 'hidden'
        });
        $('.grpmem').on('click','.remover', function() {
          $(this).closest('.grpmem').remove();
        });
    });

    var $button2=$('#add-item'),
        $row2=$('.grpit').clone(),
        $try2=$('.try2');
    $button2.click(function() {
      $row2.clone().insertAfter($try2);
      $('.remover2').css({
        visibility: ''
      });
      $('.remover2').first().css({
          visibility: 'hidden'
        });
      $('.grpit').on('click','.remover2', function() {
          $(this).closest('.grpit').remove();
      });
    });
    
});
</script>

<style type="text/css">
  label{
    margin-top: 10px;
  }
</style>