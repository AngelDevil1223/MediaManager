<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medialibrary";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM uploads order by id desc";
$result = mysqli_query($conn , $sql);

?>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Media Manager</title>

    <link rel="canonical" href="https://www.phplift.net/" />
    <link rel="publisher" href="https://plus.google.com/104843303742341697879" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Drag and drop multiple file upload using jQuery, Ajax, and PHP" />
    <meta property="og:description" content="PHPLift is a web programming blog focus on all web development tutorials specially PHP and MySQL, HTML, CSS, Ajax, Jquery, Web, Demos, JavaScript, Designing" />
    <meta property="og:site_name" content="PHPLift" />
    <meta property="og:image" content="http://www.phplift.net/wp-content/uploads/2017/01/logo.png" />
    <meta property="og:url" content="http://www.PHPLift.net/" />
    <meta property="og:site_name" content="Drag and drop multiple file upload using jQuery, Ajax, and PHP" />
    <meta property="article:publisher" content="https://www.facebook.com/PHiPLift" />
    <meta property="article:published_time" content="2014-02-12T18:37:09+00:00" />
    <meta property="article:modified_time" content="2014-02-12T18:39:48+00:00" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@PHPLift" />
    <meta name="twitter:domain" content="Drag and drop multiple file upload using jQuery, Ajax, and PHP" />
    <meta name="twitter:creator" content="@huzoorbux" />

    <meta content="PHPlift is a web programming blog focus on all web development tutorials specially PHP and MySQL, HTML, CSS, Ajax, Jquery, Web, Demos, JavaScript, Designing" name="description" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-6883622550208397",
        enable_page_level_ads: true
      });
    </script>
    <style>
      .PHPGangMessage a,
      .subbase a {
        color: blue;
      }
    </style>
  </head>
  <body>
    <style>
      body { 
        margin: 0;
      }
      #ddArea {
        height: 200px;
        border: 2px dashed #ccc;
        line-height: 200px;
        text-align: center;
        font-size: 20px;
        background: #f9f9f9;
        margin-bottom: 15px;
      }

      .drag_over {
        color: #000;
        border-color: #000;
      }

      .thumbnail {
        width: 100px;
        height: 100px;
        padding: 2px;
        margin: 2px;
        border: 2px solid lightgray;
        border-radius: 3px;
        float: left;
      }

      .d-none {
        display: none;
      }

      .d-block {
        display: block;
      }

      .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
      }

      .loading:before {
        content: "";
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
      }
      .media_container {
        display: flex;
        flex-direction: row;
        height: 100vh;
      }
      .media_sidebar {
        width: 250px;
        background-color: #283142;
      }
      .media_content {
        flex: auto;
        padding: 20px;
        padding-top: 30px;
        background-color: #eeeeee;
      }
      .content_nav {
        width: 100%;
      }
      .topnav {
        overflow: hidden;
        background-color: #283142;
      }

      .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
      }

      .topnav a:hover {
        background-color: white;
        color: black;
        cursor: pointer;
      }

      .topnav a.active {
        background-color: white;
        color: #283142;
      }

      .topnav .icon {
        display: none;
      }

      @media screen and (max-width: 600px) {
        .topnav a:not(:first-child) {display: none;}
        .topnav a.icon {
          float: right;
          display: block;
        }
      }

      @media screen and (max-width: 600px) {
        .topnav.responsive {position: relative;}
        .topnav.responsive .icon {
          position: absolute;
          right: 0;
          top: 0;
        }
        .topnav.responsive a {
          float: none;
          display: block;
          text-align: left;
        }
      }
      .content_title {
        font-size: 28px;
        color: #283142;
        margin-bottom: 5px;
      }
      h5 {
        margin-bottom: 15px;
      }
      .content_body {
        display: none;
        padding-top: 20px;
      }
      #tab1 {
        display: block;
      }
      .sidebar_menu_title {
        font-size: 24px;
        color: white;
        margin-top: 50px;
        margin-left: 50px;
        margin-bottom: 20px;
        cursor: pointer;
      }
      .sidebar_children {
        display: block;
        font-size: 18px;
        color: white;
        margin-left: 50px;
        cursor: pointer;
      }
      .gallery {
        width: 1000px;
        margin: auto;
        height: 440px;
        overflow: hidden;
      }
      .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 150px;
        right: 20px;
        background-color: #f6f7f7;
        overflow: auto;
        transition: 0.5s;
        padding-top: 10px;
        display: flex;
        flex-direction: column;
        box-shadow: 0px 6px 6px 0px rgba(0,0,0,0.3);
      }

      .sidenav a {
        /*padding: 8px 8px 8px 32px;*/
        text-decoration: none;
        font-size: 30px;
        color: #818181;
        display: block;
        transition: 0.3s;
      }

      .sidenav a:hover {
        color: #f1f1f1;
      }

      .closebtn {
        top: 0 !important;
        right: 25px !important;
        font-size: 25px !important;
        width: 20px !important;
        height: 20px !important;
        display: inline-block !important;
      }
      .imagedetail {
        border: none;
        width: 410px;
        margin-left: 20px;
        display: flex;
        flex-direction: row;
        padding-bottom: 10px;
        border-bottom: 1px solid #cccccc;
        margin-bottom: 10px;
      }
      .imageinfo {
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid #cccccc;
        width: 410px;
        margin-left: 20px;
      }
      .curimage {
        width: 100px;
        height: 100px;
        margin-left: 30px;
      }
      .curimageinput {
        width: 220px;
        background-color: #f6f7f7;
        font-size: 14px;
        color: #818181;
        padding-left: 20px;
        border: none;
      }
      .curimageinfos {
        width: 250px;
      }
      .infoLabel {
        color: #75797f;
        font-size: 14px;
      }
      .infoInput {
        color: #75797f;
        background-color: white;
        border: 1px solid #cccccc;
        border-radius: 4px;
        width: 277px;
        float: right;
        padding-left: 10px;
      }
      .boldInput {
        font-weight: bold;
      }
      .alterDiv {
        width: 390px;
        float: right;
        margin-left: 20px;
        margin-bottom: 10px;
      }
      strong {
        font-size: 12px;
        font-weight: normal;
        text-decoration: underline;
        color: lightblue;
        cursor: pointer;
      }
      strong:hover {
        color: blue;
      }
      .linkDiv {
        width: 290px;
        margin-left: 130px;
      }
      .linkDivp {
        font-size: 12px;
      }
      .infosection {
        margin-bottom: 10px;
      }
      .urlInput {
        background-color: #f6f7f7;
        font-size: 12px;
      }
      .titleDiv {
        width: 320px;
        margin-left: 90px;
      }
      .captionDiv {
        width: 340px;
        margin-left: 70px;
      }
      .desDiv {
        width: 360px;
        margin-left: 50px;
      }
      .urlDiv {
        width: 340px;
        margin-left: 70px;
      }
      .linkSidebar {
        width: 400px;
        margin-left: 20px;
      }
      .sidebarLink {
        color: lightblue !important;
        font-size: 12px !important;
        display: inline-block !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
        cursor: pointer;
      }
      .sidebarLink:hover {
        color: blue !important;
      }
      .redLink {
        color: orange !important;
      }
      .redLink:hover {
        color: red !important;
      }
      .btnDiv {
        width: 200px;
        margin-left: 130px;
      }
      .clipboardBtn {
        width: 200px;
        border: 1px solid lightblue;
        color: lightblue;
        padding: 5px;
        font-size: 12px;
        border-radius: 5px;
        transition: 0.5s;
        cursor: pointer;
      }
      .clipboardBtn:hover {
        border: 1px solid white;
        box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.2);
        color: blue;
      }
      #selecta {
        cursor: pointer;
      }
      .multiDesp {
        position: absolute;
        font-size: 20px;
        width: 300px;
        margin: auto;
        top: 230px;
        left: 50%;
      }
      #showThumb {
        width: 1000px;
      }
      .loadMore {
        display: block;
        background-color: white;
        padding: 10px;
        width: 200px;
        color: #aaaaaa;
        border: 1px solid #dddddd;
        border-radius: 3px;
        margin: auto;
        margin-top: 20px;
      }
      .loadMore:hover {
        color: #777777;
        background-color: white;
        box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.3);
      }
      #zipResult {
        width: 900px;
        margin: auto;
        height: 40vh;
        overflow: auto;
        margin-top: 15px;
        padding: 10px;
      }
      .zipForm {
        width: 700px;
        background-color: white;
        height: 150px;
        border-radius: 5px;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.3);
        padding: 10px;
        margin: auto;
      }
      .zipP {
        font-size: 20px;
        width: 200px;
        margin: auto;
      }
      #zip_file {
        width: 200px;
        margin:  auto;
      }
      #btn_zip {
        float: right;
        margin-right: 20px;
      }
      @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    </style>

    <div class="media_container">
      <div class="media_sidebar">
        <p class="sidebar_menu_title">Categories</p>
        <a class="sidebar_children">Add category</a>
        <a class="sidebar_children">Home</a>
        <a class="sidebar_children">Products</a>
        <a class="sidebar_children">Banners</a>  
      </div>
      <div class="media_content">
        <h3 class="content_title"> Media </h3>
        <h5>Manage all the media on your site, including images, video, and more</h5>
        <div class="content_nav">
          <div class="topnav" id="myTopnav">
            <a class="active" id="a1" onclick="tab(1)">Upload Files</a>
            <a id="a2" onclick="tab(2)">Insert from URL</a>
            <a id="a3" onclick="tab(3)">Insert embed</a>
            <a id="a4" onclick="tab(4)">Media Library</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="content_body" id="tab1">
          <div class="loading d-none"><img src="load.gif" alt="" /></div>
          <p class="multiDesp">Multiple file upload.</p>
          <div id="ddArea">

            Drag and Drop Files Here or
            <a id="selecta" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
              Select File(s)
            </a>
          </div>
          <div id="showThumb"></div>
          <input type="file" style="display: none;" class="d-none" id="selectfile" multiple />
        </div>
        <div class="content_body" id="tab2">
          <h3>From URL</h3>
          
          <div class="form-group">
            <label>Enter Image Url</label>
            <input type="text" name="image_url" id="image_url" class="form-control" />
           </div>
           <div class="form-group">
            <input type="button" name="upload" id="upload" value="Upload" class="btn btn-info" />
           </div>

         <div class="imageurlPreview" id="imageurlPreview"> </div>
          
        </div>
        <div class="content_body" id="tab3">
          <h3>From Embed </h3>
          <div class="zipForm"> 
            <form method="POST" enctype="multipart/form-data">
              <p class="zipP">Please Select Zip File</p>
              <br />
              <input id="zip_file" type="file" name="zip_file"/>
              <br />
              <button type="button" id="btn_zip" name="btn_zip" class="btn btn-primary">Upload</button>
            </form>
          </div>
          <div id="zipResult"></div>

        </div>
        <div class="content_body" id="tab4">
          <div class="gallery" id="gallery">
            <?php
                while($data = mysqli_fetch_assoc($result)) {
               echo "<div id='".$data['fileurl']."' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(".$data['fileurl']."); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>" ;
             } ?>
          </div>
          <button class="loadMore" id="loadMore">Load More</button>
          <div id="mySidenav" class="sidenav">
            
            <div class="imagedetail">
              <div class="curimage" id="curimage">
              </div>
              <div class="curimageinfos">
                <input class="curimageinput boldInput" id="curimagename" /><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <input class="curimageinput" id="curimagetime" />
                <input class="curimageinput" id="curimagetype" />
                <input class="curimageinput" id="curimagesize" />
                <input class="curimageinput" id="curimagedimension" />
              </div>
            </div>
            <div class="imageinfo">
              <div class="infosection alterDiv">
                <label class="infoLabel">
                  Alternative Text
                </label>
                <input class="infoInput" />
              </div>
              <div class="infosection linkDiv">
                <p class="linkDivp"><strong>Learn how to describe the purpose of the image.</strong><br /> Leave empty if the image is purely decorative.</p>
              </div>
              <div class="infosection titleDiv">
                <label class="infoLabel">
                  Title
                </label>
                <input class="infoInput" />
              </div>
              <div class="infosection captionDiv">
                <label class="infoLabel">
                  Caption
                </label>
                <textarea class="infoInput"></textarea>
              </div>
              <div class="infosection desDiv">
                <label class="infoLabel">
                  Description
                </label>
                <textarea class="infoInput" ></textarea>
              </div>
              <div class="infosection urlDiv">
                <label class="infoLabel">
                  File URL:
                </label>
                <input class="infoInput urlInput" disabled id="curimageurl"/>
              </div>
              <div class="infosection btnDiv">
                <button class="clipboardBtn">Copy URL to clipboard</button>
              </div>
            </div>
            <div class="linkSidebar">
              <a class="sidebarLink">View attachment page</a> | <a class="sidebarLink">Edit more details</a> | <a class="sidebarLink redLink">Delete permanently</a>
            </div>
          </div>
        </div>    
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      var url;
      var embed1 = [];
      var totallegnth;
      var currentpageSize = 36;
      $(document).ready(function() {
        $("#ddArea").on("dragover", function() {
          // $(this).addClass("drag_over");
          return false;
        });

        $("#ddArea").on("dragleave", function() {
          $(this).removeClass("drag_over");
          return false;
        });

        $("#ddArea").on("click", function(e) {
          file_explorer();
        });

        $("#ddArea").on("drop", function(e) {
          e.preventDefault();
          $(this).removeClass("drag_over");
          var formData = new FormData();
          var files = e.originalEvent.dataTransfer.files;
          for (var i = 0; i < files.length; i++) {
            formData.append("file[]", files[i]);
          }
          uploadFormData(formData);
        });

        $("#loadMore").on("click", function() {
          document.getElementById("gallery").innerHTML = "";
          currentpageSize += currentpageSize;
          $.post('getPage.php' , {page: currentpageSize},
            function(data) {
              var data = JSON.parse(data);
              for(var j = 0 ; j < data.length ; j ++) {
              var loadmoreDiv = '<div id="'+data[j].fileurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j].fileurl + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
              $("#gallery").append(loadmoreDiv);
              $("#gallery").css({"overflow":"auto", "width":"1020px"});
            }
          });
        });
        var prediv;
        var clickflag = 0;

          $("#gallery").on('click', function(e) {
              if(e.target.id == "gallery")
                return;
              if(clickflag == 0) {
                document.getElementById(e.target.id).style.boxShadow = " 0px 8px 8px 0px rgba(255, 0, 0, 0.7)";
                prediv = e.target.id;
                clickflag++;
              }
              else {
                document.getElementById(prediv).style.boxShadow = "0px 6px 6px 0px rgba(0, 0, 0, 0.3)";
                document.getElementById(e.target.id).style.boxShadow = "0px 8px 8px 0px rgba(255, 0, 0, 0.7)";
                prediv = e.target.id;
              }
              document.getElementById("mySidenav").style.width = "450px";

            $.post('getData.php',{ id:e.target.id },
               function(response) {
                 var response = JSON.parse(response);
                 $("#curimagename").val(response.filename);
                 var time = response.uploadtime;
                 var month = Number(time.slice(3, 5));
                 var months = ['January','Feburary','March', 'April', 'May', 'June', 'July' , 'August', 'September', 'Octorber', 'November', 'December'];
                 month = months[month];
                 var day = Number(time.slice(0, 2));
                 var year = "20" + Number(time.slice(6, 8));
                 time = month + " " + day + " " + year + " " + response.uploadtime.slice(9);
                 $("#curimagetime").val(time);
                 var exp = response.filename.slice(-3);
                 if(exp == "png" || exp == "jpg" || exp == "jpeg")
                  $("#curimagetype").val("image / " + exp);
                 else 
                  $("#curimagetype").val("File / " + exp);
                 $("#curimagesize").val(response.filesize);
                 var dimension = response.dimension.split("-");
                 dimension = dimension[0] + " by " + dimension[1] + " pixels";
                 $("#curimagedimension").val(dimension);
                 $("#curimageurl").val(response.fileurl);
                //alert(response.filename + response.fileurl + response.dimension + response.filesize + response.uploadtime);
                 $("#curimage").css({"background-image": "url('"+response.fileurl + "')" , "background-position": "center" , "background-repeat": "no-repeat" , "background-size": "cover"});
               }

            );

          })

        function file_explorer() {
          document.getElementById("selectfile").click();
          document.getElementById("selectfile").onchange = function() {
            files = document.getElementById("selectfile").files;
            var formData = new FormData();

            for (var i = 0; i < files.length; i++) {
              formData.append("file[]", files[i]);
            }
            uploadFormData(formData);
          };
        }

        function uploadFormData(form_data) {
          // $(".loading")
          //   .removeClass("d-none")
          //   .addClass("d-block");
          $.ajax({
            url: "upload.php",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
              $(".loading")
                .removeClass("d-block")
                .addClass("d-none");
                data = data.split(",");
                totallegnth = data.length;
                // data = data.slice(2,data.lastIndexOf(']')-1);
                for(var j = 0 ; j < data.length - 1 ; j++) {
                  url = data[j];
                  var embed = '<div id="data'+j+'" style="background-image:url(uploads/' + data[j] + '); opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="load.gif" /><button style="position: absolute; background-image: url(cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button></div>';
                  var uploadedurl = "http://localhost/uploads/" + data[j];
                  $("#gallery").append('<div id="'+uploadedurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(uploads/' + data[j] + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>');
                  // $("#gallery").append('<h2>asdf</h2>');
                  embed1[j] = '<div style="background-image:url(uploads/' + data[j] + '); opacity: 1; background-position: center;  background-repeat: no-repeat; background-size: cover; position: relative; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.4);" class="thumbnail"><img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="tick.png" /></div>';
                  $("#showThumb").append(embed);
                  setTimeout(function(){
                    fix()
                  }, 1000);
              }
            }
          });
        }
      });
      function fix() {
        for(var k = 0 ; k < totallegnth - 1; k++) {
          document.getElementById("data"+k).remove();
          $("#showThumb").append(embed1[k]);
        }
      }
      function tab(flag) {
        var i = 1;
        for(i = 1 ; i < 5 ; i ++) {
          var element = document.getElementById("a" + i);
          element.classList.remove("active");
        }
        document.getElementById("a"+flag).classList.add("active");
        for(i = 1 ; i < 5 ; i++) {
          document.getElementById("tab"+i).setAttribute("style", "display: none;");
        }
        document.getElementById("tab"+flag).setAttribute("style", "display: block;");
      }
      
      function closeNav() {
        document.getElementById("mySidenav").style.width = "0px"; 
      }

      var fromurlGlobal;
      function fix1(flag, flag1) {
        document.getElementById("fromurlembed").remove();
        $("#imageurlPreview").append(flag1);
        // $("#showThumb").append(flag);
        $("#gallery").append(flag);
      }

      $(document).ready(function(){
       $('#upload').click(function(){
        var image_url = $('#image_url').val();
        if(image_url == '')
        {
         alert("Please enter image url");
         return false;
        }
        else
        {
         // $('#upload').attr("disabled", "disabled");
         $.ajax({
          url:"oneupload.php",
          method:"POST",
          data:{image_url:image_url},
          dataType:"JSON",
          beforeSend:function(){
           // $('#upload').val("Processing...");
          },
          success:function(data)
          {
            $('#image_url').val('');
            var fromurlresult = '<div id="fromurlembed" style="background-image:url(' + data.image + '); opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="load.gif" /><button style="position: absolute; background-image: url(cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button></div>';
            fromurlGlobal = '<div id="'+data.image+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
            fromurlGlobal1 = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
            $('#imageurlPreview').append(fromurlresult);
            setTimeout(function(){
              fix1(fromurlGlobal, fromurlGlobal1)
            },1000);
          }
         })
        }
       });
      });


      $(document).ready(function(){

      var zipRealDiv = [];
      var zipRealCnt = 0;
      var galleryRealDiv = [];

      function fix2() {
        document.getElementById("zipResult").innerHTML = "";
        for(var j = 0 ; j < zipRealCnt ; j++) {
          $("#zipResult").append(zipRealDiv[j]);
          $("#gallery").append(galleryRealDiv[j]);
        }
        setTimeout(function(){
              window.location.href = "/";
            },300);
      }

        $('#btn_zip').on('click', function(){
          var file_data = $('#zip_file').prop('files')[0];
          if(file_data != undefined){
            var form_data = new FormData();
            form_data.append('zip_file', file_data);
            $.ajax({
              type: 'POST',
              url: 'extract.php',
              contentType: false,
              processData: false,
              data: form_data,
              success: function(data){
                // $('#result').html(data);

                var data = JSON.parse(data);
                zipRealCnt = data.length;
                for(var j = 0 ; j < data.length ; j ++) {
                  var zipDiv = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img style="position: absolute; width: 30px; height: 30px; top: 33px; left: 33px;" src="load.gif" /></div>';

                  zipRealDiv[j] = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="tick.png" /></div>'

                  galleryRealDiv[j] = '<div id="' + data[j] + '" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>' 

                  $("#zipResult").append(zipDiv);
                }
                setTimeout(function(){
                  fix2()
                }, 1000);
              }
            });
          }
          return false;
        });
      });

    </script>
  </body>
</html>
