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
            <input class="form-control" id="borrowerid" readonly="readonly" value="<?php $MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName); $result = mysqli_query($MyConnection,"SELECT MAX(borrower_id) AS max FROM borrower"); $row = mysqli_fetch_array($result, MYSQLI_NUM); echo $row[0]+1;?>" />
          </div>
          
          <label class="try" for="members">Group Members: </label>
          <div class="row grpmem" style="padding: 5px; margin: auto;">
            <div class="col-md-4">
              <input type="text" name="sid[]" class="form-control" placeholder="Student ID (20XX-XXXXX)*" required="true">
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
          <div class="container-fluid" id="clonegrp">
            <div class="row grpit" style="padding: 5px; margin: auto;">
            <div class="col-md-7">
              <input type="text" name="it[]" class="form-control" id="item" placeholder="Chemical/Equipment*" required="true">
            </div>
            <div class="col-md-2">
              <input type="text" name="amount[]" class="form-control" placeholder="Amount*" required="true">
            </div>
            /<div class="col-md-1">
              <input type="text" class="form-control" name="max[]" id="max" placeholder="Max" readonly="readonly">
            </div>
            <div class="col-md-1">
              <input type="text" class="form-control" id="unit" placeholder="Unit" readonly="readonly">
            </div>
            <button class="btn btn-danger remover2" form="" style="float:right; cursor: pointer; visibility: hidden;"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <center><button type="button" class="btn btn-info" id="add-item" name="add-item" onmouseover="" style="cursor: pointer; margin-top: 20px; text-align: right;">Add Item</button></center>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success btn-lg btn-block" id="confirm" data-toggle="modal" data-target="#myModal" style="margin: auto; margin-top: 60px; cursor: pointer;">
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
                    <div class="row">
                      <div class="col-sm-5">
                        <strong>Borrower ID:</strong>
                      </div>
                      <div class="col-sm-5">
                        
                      </div>
                      <div class="w-100"></div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: white; color: black;">
                  <div class="text-center" id="footmsg" style="float: left; text-align: left;">
                    <p>Are you sure you want to submit?</p>
                  </div>
                  <span style="width: 20px;"></span>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button submit" class="btn btn-success" id="submitter" style="cursor: pointer;">Submit</button>
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
        $try2=$('#clonegrp');
    $button2.click(function() {
      $row2.clone().appendTo($try2);
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
  $(document).ready(function() {
      $("#confirm").click(function(event) {
        $(".modal-body").html("<div class='row' id='inner'></div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Borrower Id: </strong>"+$("#borrowerid").val()+"</div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Group Members: </strong></div>");
        
        //GATEHRING ALL NAME INPUTS
        var id=new Array();
        var lname=new Array();
        var fname=new Array();
        var ctr=0;
        $('input[name^="sid"]').each(function() {
            id[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="lname"]').each(function() {
            lname[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="fname"]').each(function() {
            fname[ctr]=$(this).val();
            ctr++;
        });
        for (var i = 0; i < id.length; i++) {
          $("#inner").append("<div class='col-sm-7 text-center'><strong>"+lname[i]+", </strong>"+fname[i]+"</div><div class='col-sm-5 text-center'><strong>"+id[i]+"</strong></div>");
        }
        //////////////////////////////////////////////////////////
        
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Subject: </strong>"+$("#subj").val()+" ("+$("#prof").val()+")</div>");
        $("#inner").append("<div class='col-sm-12' style='margin-top:10px; margin-bottom:10px;'><strong>Items: </strong></div>");

        //GATEHRING ALL ITEM INPUTS
        var it=new Array();
        var amt=new Array();
        ctr=0;
        $('input[name^="it"]').each(function() {
            it[ctr]=$(this).val();
            ctr++;
        });
        ctr=0;
        $('input[name^="amount"]').each(function(){
            amt[ctr]=$(this).val();
            ctr++;
        });

        for (var i = 0; i < it.length; i++) {
          $("#inner").append("<div class='col-sm-7 text-center'><strong>"+amt[i]+"</strong> - "+it[i]+"</div><div class='col-sm-5 text-center'></div>");
        }
        //////////////////////////////////////////////////////////

        //ERROR CHECKING
        var flag=0;
        var subj=$("#subj").val();
        if(subj==""){
          flag=1;
        }

        for (var i = 0; i < id.length; i++) {
          if (flag==1){
            break;
          }
          if (id[i]==""){
            flag=1;
            break;
          }
          if (lname[i]==""){
            flag=1;
            break;
          }
          if(fname[i]==""){
            flag=1;
            break;
          }
        }
        for (var i = 0; i < it.length; i++) {
          if (it[i]==""){
            flag=1;
            break;
          }
          if (amt[i]=="") {
            flag=1;
            break;
          }
        }

        //CHECK IF ALL SID IS A NUMBER
        //CHECK IF SID EXCEEDS 9 NUMERALS
        //CHECK IF AMT IS A NUMBER
        //CHECK IF AMT EXCEEDS MAX

        if (flag==1) {
          $("#footmsg").html("");
          $("#inner").html("Error: Some input fields have invalid values. Kindly recheck.");
          $("#submitter").attr('disabled', 'disabled');
          flag=0;
        }else{
          $("#footmsg").html("Are you sure you want to submit?");
          flag=0;
          $("#submitter").prop('disabled', false);
        }
      });

  });

  $(document).on('keydown', 'document', function(event) {
    var key=event.which;
    if (key==13) {
      $("#confirm").click();
    }
  });

  $('#clonegrp').on('keyup','#item', function() {
    if ($(this).closest('.grpit').find('#item').val()=='') {
      $(this).closest('.grpit').find('#max').val('');
      $(this).closest('.grpit').find('#unit').val('');
    }else{
      <?php 
        $query2="SELECT Name FROM glasswares;";
        $row2=mysqli_query($MyConnection,$query);
        $result2=mysqli_fetch_array($row,MYSQLI_ASSOC);
      ?>
      alert("<?php json_encode($result2[0])?>");
      $(this).closest('.grpit').find('#max').val('catch');
      $(this).closest('.grpit').find('#unit').val('catch');
    }
    
  });
</script>

<style type="text/css">
  label{
    margin-top: 10px;
  }
</style>