<?php

  include 'config.php';

  $sql = "SELECT * FROM uploads order by id desc";
  $result = mysqli_query($conn , $sql);

  $sql1 = "SELECT * FROM categories";
  $result1 = mysqli_query($conn , $sql1);
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Media Manager</title>

    <link rel="canonical" href="https://www.phplift.net/" />
    <link rel="publisher" href="https://plus.google.com/104843303742341697879" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    <link rel="stylesheet" type="text/css" href="./assets/jquery-ui-1.8.7.custom.css" /> 
    <link rel="stylesheet" type="text/css" href="./assets/custom.css" />


    <script src="https://tutsplus.s3.amazonaws.com/tutspremium/web-development/133_canvasEditor/demo/jquery-1.4.4.min.js"></script>
      <script src="https://tutsplus.s3.amazonaws.com/tutspremium/web-development/133_canvasEditor/demo/jquery-ui-1.8.7.custom.min.js"></script>
    <script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src=" https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.js" type="text/javascript"></script>
    
    <style>
      .PHPGangMessage a,
      .subbase a {
        color: blue;
      }
    </style>
  </head>
  <body id = "body">

    <div class="media_container">
      <div class="media_sidebar" id="media_sidbar">
        <p class="sidebar_menu_title">Products</p>
        <p class="sidebar_menu_title">Webpage</p>
        <p class="sidebar_menu_title">Site</p>
        <p class="sidebar_menu_title">Categories</p>
        <p class="sidebar_menu_title">Currency</p>  
      </div>
      <div class="media_content">
        <div id="mySidenav1" class="sidenav1">
          Save Successfully!
        </div>
        <div id="mySidenav2" class="sidenav1">
          Copy clipboard!
        </div>

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
          <button class="uploadbtn" id="imguploadbtn">Image Upload</button>
          <button class="uploadbtn" id="zipuploadbtn">Zip Upload</button>
          <div class="loading d-none"><img src="./assets/load.gif" alt="" /></div>
          <div id="imauploaddiv">
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

          <div class="zipForm" style="display: none;" id="zipForm"> 
            <form method="POST" class="zipForm1" enctype="multipart/form-data">
              <p class="zipP">Please Select Zip File</p>
              <br />
              <input id="zip_file" type="file" name="zip_file"/>
              <br />
              <button type="button" id="btn_zip" name="btn_zip" class="btn btn-primary">Upload</button>
            </form>
          </div>
          <div id="zipResult"></div>
        
        </div>
        <div class="content_body" id="tab2">
          <div class="insertUrlCntdiv">
            <label class="insertUrlCntlabel">Insert</label>
            <textarea class="insertUrlCntinput" id="insertUrlCntinput" type="text" name=""></textarea>
            <button class="insertUrlCntbtn" id="insertUrlCntbtn" > OK </button>
          </div>
          <div class="imageurlPreview" id="imageurlPreview" style="display: flex;"> </div>
          
        </div>
        <div class="content_body" id="tab3">

          <div class="embedDiv">
            <textarea class="embedinput" id="embedValue"></textarea>
            <button class="btn btn-primary embedBtn" id="embedBtn">
              Embed
            </button>
          </div>
          <div class="embedResult" id="embedResult" style="display: flex;">
            
          </div>
        </div>
        <div class="content_body" id="tab4">
          <div class="searchDiv">
            <select class="select" id="typeMediafilter">
              <option>All media items</option>
              <option value="Image">Image</option>
              <option value="Audio">Audio</option>
              <option value="Video">Video</option>
            </select>

            <!-- <select class="select">
              <option>All dates</option>
            </select> -->
            <div class="dataRangeDiv">
              <div class="dataRange">
                <label>From:</label>
                <input class="dateInput" type="date" name="" id="dateFrom" />
              </div>

              <div class="dataRange">
                <label>To:</label>
                <input class="dateInput" type="date" name="" id="dateTo" />
              </div>
            </div>

            <div class="dropdown">
              <button class="dropbtn">Search By Tag</button>
              <div class="dropdown-content" id="checkboxList">
                <?php 
                  while ($data1 = mysqli_fetch_assoc($result1)) {
                    echo "<input type='checkbox' class='checkboxInput' value='".$data1['cate_name']."' /><a id=a>".$data1['cate_name']."</a><br />";
                  }
                ?>
              </div>
            </div>

            <div class="searchinputDiv">
              <div class="searchFloatDiv">
                <label class="searchLabel">Search </label>
                <input class="searchInput" id="searchInput" />
              </div>
            </div>
          </div>
          <div class="galleryParent" id="galleryParent">  
            <div class="gallery" id="gallery">
              <?php
                  while($data = mysqli_fetch_assoc($result)) {
                    $comp = substr($data['fileurl'], -3);
                    if ($comp == "jpg" || $comp == "peg" || $comp == "png") {
                      echo "<div id='".$data['fileurl']."' style=' margin-right: 10px; margin-bottom: 10px;  background-image: url(".$data['fileurl']."); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>" ;
                    }
                    else if($comp == "mp4" || $comp == "avi") {
                      echo '<video id="'.$data['fileurl'].'" src="'.$data['fileurl'].'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right: 10px; margin-bottom: 10px; "><source type="video/mp4"></video>';
                    }
                  } 
              ?> 
                    
                     
            </div>
          </div>
          <button class="loadMore" id="loadMore">Load More</button>
          <div id="mySidenav" class="sidenav">
            
            <div class="imagedetail">
              <div class="curimage" id="curimage" href="#openModal">
              </div>
              <img id="curImageObject" style="display: none;" />
              <div class="curimageinfos">
                <input class="curimageinput boldInput" id="curimagename" /><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <input class="curimageinput" id="curimagetime" />
                <input class="curimageinput" id="curimagetype" />
                <input class="curimageinput" id="curimagesize" />
                <input class="curimageinput" id="curimagedimension" />
                <input style="display: none;" id="curimageUrl">
              </div>
            </div>
            <div class="imageinfo">
              <div class="infosection alterDiv">
                <label class="infoLabel">
                  Alternative Text
                </label>
                <input class="infoInput" id="altText" />
              </div>
              <div class="infosection linkDiv">
                <p class="linkDivp"><strong>Learn how to describe the purpose of the image.</strong><br /> Leave empty if the image is purely decorative.</p>
              </div>
              <div class="infosection titleDiv">
                <label class="infoLabel">
                  Title
                </label>
                <input class="infoInput" id="imgTitle"/>
              </div>
              <div class="infosection captionDiv">
                <label class="infoLabel">
                  Caption
                </label>
                <input class="infoInput" id="imgCaption"></input>
              </div>
              <div class="infosection tagDiv">
                <label class="infoLabel">
                  Tag
                </label>
                <input class="infoInput" id="imgTag"></input>
              </div>
              <div class="infosection desDiv">
                <label class="infoLabel">
                  Description
                </label>
                <textarea class="infoInput" id="imgDes"></textarea>
              </div>
              <div class="infosection urlDiv">
                <label class="infoLabel">
                  File URL:
                </label>
                <input class="infoInput urlInput" disabled id="curimageurl"/>
              </div>
              <div class="infosection btnDiv">
                <button class="clipboardBtn" id="copyurlbtn">Copy URL to clipboard</button>
                <button class="clipboardBtn sidebarSavebtn" id="sideimgSave"> Save </button>
              </div>
            </div>
            <div class="linkSidebar">
              <a class="sidebarLink" id="editImage">Edit more details</a> | <a class="sidebarLink redLink" id="deleteImg">Delete permanently</a>
            </div>
          </div>
          <div id="myModal" class="modal">
            <div class="modal-content">
              <div class="modal-header">
                <span class="close">&times;</span>
                <h2 class="editImagetitle"> Edit Image </h2>
              </div>
              <div class="modal-body" id="modalBody">
                <div id="imageEditor">
                 
                  <section id="toolbar">
                    <button class="editbtns" id="editSave" title="Save">Save</button>
                    <button class="editbtns" id="rotateL" title="Rotate Left">Rotate Left</button>
                    <button class="editbtns" id="rotateR" title="Rotate Right">Rotate Right</button>
                  </section>
                   <section id="editorContainer">
                    <div id="editor">
                      
                    </div>
                  </section>
                </div>
                <div id="imageInputer">
                  <div class="imageInputer_sec">
                    <label class="width_label">Width:</label><input class="img_resize_input" id="img_resize_width" />
                  </div>
                  <div class="imageInputer_sec">
                    <label class="height_label">Height:</label><input class="img_resize_input" id="img_resize_height" />
                  </div>
                  <div class="imageInputer_sec">
                    <button class="resize_btn editbtns" id="img_resize_btn">Resize</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>    
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>

      // checkbox tag search


      var url;
      var embed1 = [];
      var totallegnth;
      var currentpageSize = 27;
      var prediv;
      var clickflag = 0;
      var totalUploadImageCnt = 0;
      var dateFromflag = 0;
      var dateToflag = 0;
      var curimagewidth = 0;
      var curimageheight = 0;
      var rotateLeftflag = 0,
          rotateRightflag = 0;
      var imageWidth = 0,
          imageHeight = 0;
      $(document).ready(function() {

        $.post("upload.php" , {initial: "true"},function(data) {
        
        });

        $.post("upload.php", {getRow:"true"}, function(data) {
            totalUploadImageCnt = data;
            if (totalUploadImageCnt <= 27) {
              document.getElementById("loadMore").setAttribute("style","display: none;");
            }
        });

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
          if (currentpageSize > totalUploadImageCnt) {
            document.getElementById("loadMore").setAttribute("style", "display: none; ");
          }
          $.post('upload.php' , {page: currentpageSize},
            function(data) {
              var data = JSON.parse(data);
              var loadmoreDiv = 0;
              for(var j = 0 ; j < data.length ; j ++) {
                if(data[j].fileurl.slice(-3) == "jpg" || data[j].fileurl.slice(-3) == "png" || data[j].fileurl.slice(-3) == "peg") {
                    loadmoreDiv = '<div id="'+data[j].fileurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j].fileurl + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                }
                else if(data[j].fileurl.slice(-3) == "mp4" || data[j].fileurl.slice(-3) == "avi") {
                    loadmoreDiv = '<video id="'+data[j].fileurl+'" src="'+data[j].fileurl+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); margin-right: 10px; margin-bottom: 10px;  width:100px ; height: 100px; "></button><source type="video/mp4"></video>';
                }
                $("#gallery").append(loadmoreDiv);
               
            }
            $("#galleryParent").css({"overflow":"auto" , "width":"1020px"});
          });
        });
    

        $("#gallery").on('click', function(e) {
            
            console.log(e.target.id);
            if(e.target.id == "gallery")
              return;
            if(clickflag == 0) {
              console.log(clickflag);
              document.getElementById(e.target.id).style.boxShadow = " 0px 8px 8px 0px rgba(255, 0, 0, 0.7)";
              prediv = e.target.id;
              clickflag++;
            }
            else {
              if(prediv != null)  {
                 document.getElementById(prediv).style.boxShadow = "0px 6px 6px 0px rgba(0, 0, 0, 0.3)";
              }
              document.getElementById(e.target.id).style.boxShadow = "0px 8px 8px 0px rgba(255, 0, 0, 0.7)";
              prediv = e.target.id;
            }
            document.getElementById("mySidenav").style.width = "450px";

          $.post('upload.php',{ id:e.target.id, getdata: "true" },  function(response) {
               var response = JSON.parse(response);
               $("#curimagename").val(response.filename);
               var time = response.uploadtime;
               var month = Number(time.slice(3, 5));
               var months = ['','January','Feburary','March', 'April', 'May', 'June', 'July' , 'August', 'September', 'Octorber', 'November', 'December'];
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
                curimagewidth = Number(dimension[0]);
               curimageheight = Number(dimension[1]);
               dimension = dimension[0] + " by " + dimension[1] + " pixels";

              
               $("#curimagedimension").val(dimension);
               $("#curimageurl").val(response.fileurl);
              
               if(response.cate_name == null) {
                $("#imgTag").val("");
                document.getElementById("imgTag").disabled = false;
               }
               else {
                $("#imgTag").val(response.cate_name);
                document.getElementById("imgTag").disabled = false;
               }
              
               $("#curimageUrl").val(response.fileurl);
               $("#altText").val(response.alttext);
               if(response.title == '') {
                $("#imgTitle").val('');
                // $("#imgTitle").val(response.filename.slice(0,response.filename.lastIndexOf(".")));
               }
               else {
                $("#imgTitle").val(response.title);
               }
               $("#imgDes").val(response.description);
               $("#imgCaption").val(response.caption);
              //alert(response.filename + response.fileurl + response.dimension + response.filesize + response.uploadtime);
               $("#curimage").css({"background-image": "url('"+response.fileurl + "')" , "background-position": "center" , "background-repeat": "no-repeat" , "background-size": "cover"});
               document.getElementById("curImageObject").src = response.fileurl;
             }

          );

        });

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

        // Drag and drop files upload part in first tab named "Upload Files"

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
                $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                });
                data = data.split(",");
                totallegnth = data.length;
                // data = data.slice(2,data.lastIndexOf(']')-1);
                for(var j = 0 ; j < data.length - 1 ; j++) {
                  //var uploadedurl = "http://localhost/uploads/" + data[j];
                  var uploadedurl = "<?php echo $actual_link; ?>uploads/" + data[j];
                  url = data[j];
                  var embed = '';
                  if(uploadedurl.slice(-3) == "mp4" || uploadedurl.slice(-3) == "avi") {
                    embed = '<video id="data'+j+'" src="'+uploadedurl+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right:10px; margin-bottom: 10px; display: inline-block; "><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /><button style="position: absolute; background-image: url(./assets/cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button><source type="video/mp4"></video>';
                    embed1[j] = '<video id="data'+j+'" src="'+uploadedurl+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; display: inline-block; margin-right: 10px; margin-bottom: 10px; "> <img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="./assets/tick.png" /><source type="video/mp4"></video>';
                    $("#gallery").append('<video id="'+uploadedurl+'" src="'+uploadedurl+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; "></button><source type="video/mp4"></video>');
                  }
                  
                  else if(uploadedurl.slice(-3) == "jpg" || uploadedurl.slice(-3) == "png") {
                    embed = '<div id="data'+j+'" style="background-image:url(uploads/' + data[j] + '); opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /><button style="position: absolute; background-image: url(./assets/cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button></div>';
                    
                    $("#gallery").append('<div id="'+uploadedurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(uploads/' + data[j] + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>');
                    embed1[j] = '<div style="background-image:url(uploads/' + data[j] + '); opacity: 1; background-position: center;  background-repeat: no-repeat; background-size: cover; position: relative; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.4);" class="thumbnail"><img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="./assets/tick.png" /></div>';
                  }
                  $("#showThumb").append(embed);
                  setTimeout(function(){
                    fix()
                  }, 1000);
              }
            }
          });
        }

        // DateRange calculate function
        function DateRange(flag, value) {
          document.getElementById("gallery").innerHTML = '';
          if(flag == 0) {
            if(value == "from") {
              var startFrom = $("#dateFrom").val();
              startFrom = Number(startFrom.replace(/\D/g, ''));
              $.post("upload.php", {startFrom}, function(data) {
                data = JSON.parse(data);
                drawdate = [];
                for(var i = 0 ; i < data.length ; i++) {
                  document.getElementById("gallery").innerHTML += '<div id="'+data[i].fileurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[i].fileurl + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                }
              });
            }
            else if(value == "to") {
              var startTo = $("#dateTo").val();
              startTo = Number(startTo.replace(/\D/g , ''));
              $.post("upload.php", {startTo}, function(data) {
                data = JSON.parse(data);
                for(var i = 0 ; i < data.length ; i++) {          
                  document.getElementById("gallery").innerHTML += '<div id="'+data[i].fileurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[i].fileurl + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                }
              });
            }
          }
          else if(flag == 1){
            var nextFrom = $("#dateFrom").val();
            nextFrom = Number(nextFrom.replace(/\D/g , ''));
            var nextTo = $("#dateTo").val();
            nextTo = Number(nextTo.replace(/\D/g , ''));
            $.post("upload.php", { nextFrom , nextTo}, function(data) {
              data = JSON.parse(data);
              for(var i = 0 ; i < data.length ; i++) {
                document.getElementById("gallery").innerHTML += '<div id="'+data[i].fileurl+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[i].fileurl + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
              }
            });
          }
        }
        // when click data range picker
        $("#dateFrom").change(()=>{
          if(dateToflag == 0) {
            dateFromflag = 1;
            DateRange(0,"from");
          }
          else {
            DateRange(1, " ");
   
          }
        });
        $("#dateTo").change(()=>{
          if(dateFromflag == 0) {
            DateRange(0,"to");
            dateToflag = 1;
          }
          else {
            DateRange(1, "");
          }
        });
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

      //  tab2 when click url upload button
      $(document).ready(function(){

        // when embed btn click
        $("#embedBtn").click(()=>{
          var result = $("#embedValue").val();
          result = result.split(/\n/);
          var totalembedcnt = result.length;
          var indexembed = 0;
          const myInterval1 = setInterval(function() {
            if(indexembed == totalembedcnt) {
              $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                });
              clearInterval(myInterval1);
            } else {
              var embed = result[indexembed];
              var embedsource = '';
              var embedresult , embedGlobal , embedGlobal1;
              if(embed.slice(0, 8) == "<iframe " || embed.slice(-9) == "</iframe>") {
                var draw = embed.split("src=");
                var draw1 = draw[1].split(">");
                embedsource = draw1[0].slice(1 , draw1[0].length -1);
              }
              else if(embed.slice(0, 4) == "http") {
                embedsource = embed;
              }
                $.ajax({
                        url:"upload.php",
                        method:"POST",
                        data:{image_url:embedsource},
                        dataType:"JSON",
                        success:function(data)
                        {
                          var ext = data.image.slice(-3);
                          if(ext == "jpg" || ext == "png" || ext == "peg") {
                            embedresult = '<div id="embedremove" style="background-image:url(' + data.image + '); opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /><button style="position: absolute; background-image: url(./assets/cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button></div>';
                            embedGlobal = '<div id="'+data.image+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                            embedGlobal1 = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img src="./assets/tick.png" style="position:absolute; width:30px ; height: 30px; top: 70px; left: 70px; " /></div>';
                          }
                          else if(ext == "mp4" || ext == "avi") {
                            embedresult = '<video id="embedremove" src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right:10px; margin-bottom: 10px; display: inline-block; "><source type="video/mp4"></video>';
                            embedGlobal = '<video id="'+data.image+'" src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; display: inline-block; margin-right: 10px; margin-bottom: 10px; "><source type="video/mp4"></video>';
                            embedGlobal1 = '<video src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right: 10px ; margin-bottom: 10px; display: inline-block; "><source type="video/mp4"></video>';
                          }
                          $("#embedResult").append(embedresult);
                          
                          setTimeout(function(){

                            document.getElementById("embedremove").remove();
                            $("#gallery").append(embedGlobal);
                            $("#embedResult").append(embedGlobal1);
                            indexembed++;
                          },1500); 

                        },
                        error: function(err) {
                          var fromurlresult = '<div id="fromurlembed" style=" opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /></div>';
                            $('#embedResult').append(fromurlresult);
                          setTimeout(function(){
                             document.getElementById("fromurlembed").remove();
                            $("#embedResult").append('<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; padding-top: 40px; padding-left: 30px; height: 100px;">Failed</div>');
                            indexembed++;
                          },1500);
                        }
                      });
                    }
                }, 4000);
        });

        // Upload from multiple Url in Second tab named "Insert from URL"
        var totalUrlcnt;

        $("#insertUrlCntbtn").click(function(e) {
          var data = $("#insertUrlCntinput").val();
          data = data.split(/\n/);
          totalUrlcnt = data.length;
          console.log(totalUrlcnt + " totalurlcnt ");
          var fromurlresult = '';
            var k = 0;
            const myInterval = setInterval(function() {
              if(k == totalUrlcnt) {

                $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                });
                clearInterval(myInterval);
              }
              else {
                var image_url = data[k];
                $.ajax({
                url:"upload.php",
                method:"POST",
                data:{image_url:image_url},
                dataType:"JSON",
                success:function(data)
                {
                  $('#image_url').val('');
                  var ext = data.image.slice(-3);
                  if(ext == "jpg" || ext == "png" || ext == "peg") {
                    fromurlresult = '<div id="fromurlembed" style="background-image:url(' + data.image + '); opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /><button style="position: absolute; background-image: url(./assets/cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button></div>';
                    fromurlGlobal = '<div id="'+data.image+'" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                    fromurlGlobal1 = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data.image + '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img src="./assets/tick.png" style="position:absolute; width:30px ; height: 30px; top: 70px; left: 70px; " /></div>';
                  }
                  else if(ext == "mp4" || ext == "avi") {
                    fromurlresult = '<video id="fromurlembed" src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right:10px; margin-bottom: 10px; display: inline-block; "><source type="video/mp4"></video>';
                    fromurlGlobal = '<video id="'+data.image+'" src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; display: inline-block; margin-right: 10px; margin-bottom: 10px; "><source type="video/mp4"></video>';
                    fromurlGlobal1 = '<video src="'+data.image+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right: 10px ; margin-bottom: 10px; display: inline-block; "><source type="video/mp4"></video>';
                  }
                  $('#imageurlPreview').append(fromurlresult);
                  
                  setTimeout(function(){
                    document.getElementById("fromurlembed").remove();
                    $("#gallery").append(fromurlGlobal);
                    $("#imageurlPreview").append(fromurlGlobal1);
                    k++;
                  },1500);
                },
                error: function(err) {
                  var fromurlresult = '<div id="fromurlembed" style=" opacity: 0.7; background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative;" class="thumbnail"><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /></div>';
                    $('#imageurlPreview').append(fromurlresult);
                  setTimeout(function(){
                     document.getElementById("fromurlembed").remove();
                    $("#imageurlPreview").append('<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; padding-top: 40px; padding-left: 30px; height: 100px;">Failed</div>');
                    k++;
                  },1500);
                }
                });
              }
            },4000);  
        })

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
                // window.location.href = "/";
              },300);
          $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                });
        }

        // zip file upload part in First tab named "Upload Files"
        $('#btn_zip').on('click', function(){
          var file_data = $('#zip_file').prop('files')[0];
          if(file_data != undefined){
            var form_data = new FormData();
            form_data.append('zip_file', file_data);
            $.ajax({
              type: 'POST',
              url: 'upload.php',
              contentType: false,
              processData: false,
              data: form_data,
              success: function(data){
                // $('#result').html(data);
                $("#fakeInput").val('');
                var data = JSON.parse(data);
                zipRealCnt = data.length;
                var zipDiv = "";
                for(var j = 0 ; j < data.length ; j ++) {
                  console.log(data[j]);
                  if (data[j].slice(-3) == "jpg" || data[j].slice(-3) == "png" || data[j].slice(-3) == "peg") {
                    zipDiv = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img style="position: absolute; width: 30px; height: 30px; top: 33px; left: 33px;" src="./assets/load.gif" /></div>';

                    zipRealDiv[j] = '<div style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"><img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="./assets/tick.png" /></div>';

                    galleryRealDiv[j] = '<div id="' + data[j] + '" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(' + data[j]+ '); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;"></div>';
                  }
                  else if(data[j].slice(-3) == "avi" || data[j].slice(-3) == "mp4") {
                    zipDiv = '<video src="'+data[j]+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right: 10px; margin-bottom: 10px; display: inline-block; "><img style="position: absolute; width: 50px; height: 50px; top: 25px; left: 25px;" src="./assets/load.gif" /><button style="position: absolute; background-image: url(./assets/cancel.png); color: white; background-position: center; background-size: cover;  background-repeat: no-repeat; width: 30px; height:30px; font-size: 8px; top: 33px; left: 33px;"></button><source type="video/mp4"></video>';

                    zipRealDiv[j] = '<video src="'+data[j]+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-right: 10px; margin-bottom: 10px; display: inline-block;"> <img style="position: absolute; width: 30px; height: 30px; top: 70px; left: 70px;" src="./assets/tick.png" /><source type="video/mp4"></video>';

                    galleryRealDiv[j] = '<video id="'+data[j]+'" src="'+data[j]+'" controls style="box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); width:100px ; height: 100px; margin-bottom: 10px; margin-right: 10px; display: inline-block;"></button><source type="video/mp4"></video>';
                  }
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
        
        // check multiple checkbox
        var categories_flag = 0;
        $("#media_sidbar").on("click", function(e) {

          switch(e.target.id) {
            case 'categories_p': 
            {
              if(categories_flag % 2 == 0) {
                document.getElementById("checkboxList").setAttribute("style", "display: block;");
                categories_flag += 1; 
              }
              else {
                document.getElementById("checkboxList").setAttribute("style", "display: none;");
                categories_flag += 1;  
              }
            }
          }

        });

        var checkboxflag = 0;
        $("#checkboxList").on("click", function(e) {
          if(e.target.id == "")
          {
            if(e.target.checked == true) {
              if(checkboxflag == 0) {
                document.getElementById("gallery").innerHTML = "";
              }
              checkboxflag++;
              document.getElementById("loadMore").setAttribute("style","display : none;");
              $.post("upload.php", { tag:e.target.value , searchtag: "true" } , function(data){
                var data = JSON.parse(data);
                for(var j = 0 ; j < data.length ; j++) {
                  var insertDiv = "<div id='"+data[j].fileurl+"' class='"+e.target.value+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url("+data[j].fileurl+"); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>";
                  document.getElementById("gallery").innerHTML += insertDiv;
                }
              });
            }
            else {
              document.getElementById("gallery").innerHTML = "";
              var elems = document.getElementsByClassName("checkboxInput");
              var truetag = '';
              for(var i = 0 ; i < elems.length ; i++) {
                  if(elems[i].checked == true) {
                    truetag =truetag + elems[i].value + ',';
                  }
              }

              $.post("upload.php" , {tag:e.target.value , truetag } , function(data) { 
                var data = JSON.parse(data);
                var temp = [];
                var sameflag = 0;
                var box = '';

                for(var j = 0 ; j < data.length ; j++) {
                  box = data[j].fileurl;
                  for(var l = j + 1 ; l < data.length ; l++) {
                    if(box == data[l].fileurl) {
                      temp.push(l);
                    }
                  }            
                }
                for(var j = 0 ; j < data.length ; j ++) {
                  for(var l = 0 ; l < temp.length ; l++) {
                    if(data[j].fileurl == temp[l])
                      sameflag = 1;
                  }
                  if(sameflag != 1) {
                    var insertDiv = "<div id='"+data[j].fileurl+"' class='"+e.target.value+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url("+data[j].fileurl+"); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>";
                    document.getElementById("gallery").innerHTML += insertDiv;
                    sameflag = 0;
                  }
                }  
              });
              checkboxflag--;
              var elements = document.getElementsByClassName(e.target.value);
              while(elements.length > 0){
                    elements[0].parentNode.removeChild(elements[0]);
                }
              if(checkboxflag == 0) {
               
                $.post("upload.php", {getall: "true"}, function(data) {
                  var data = JSON.parse(data);
                  for(var j = 0 ; j < data.length ; j++) {
                    var insertDiv = "<div id='"+data[j].fileurl+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url("+data[j].fileurl+"); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>";
                    $("#gallery").append(insertDiv);
                  }
                  document.getElementById("galleryParent").style.overflow = "hidden";
                })
                if (totalUploadImageCnt > 27) {
                  document.getElementById("loadMore").setAttribute("style","display: block;");
                }
              }
            }
          }
        })


        // sidebar save btn click
        $("#sideimgSave").on("click", function() {
          var currentImgurl = $("#curimageUrl").val();
          var altText = $("#altText").val();
          var imgTitle = $("#imgTitle").val();
          var imgCaption = $("#imgCaption").val();
          var imgDes = $("#imgDes").val();
          var imgTag = $("#imgTag").val();

          $.post("upload.php" , {
            url: currentImgurl,
            altText,
            imgTitle,
            imgCaption,
            imgDes,
            imgTag,
            eachimg:"true",
            }, function(data){
              document.getElementById("mySidenav1").style.width = "300px";
              setTimeout(function(){
                document.getElementById("mySidenav1").style.width = "0";
              },2000);
              document.getElementById("imgTag").disabled = true;
            })
          });

        $("#searchInput").keyup(function() {
          var indexWord = $("#searchInput").val();
          if(indexWord == '')
          {
            document.getElementById("gallery").innerHTML = '';
            //get all data  part 
            $.post("upload.php", {getall: "true"} ,function(data) {
               var data = JSON.parse(data);
                for(var j = 0 ; j < data.length ; j++) {
                  var insertDiv = "<div id='"+data[j].fileurl+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url("+data[j].fileurl+"); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>";
                  $("#gallery").append(insertDiv);
                }
                document.getElementById("galleryParent").style.overflow = "hidden";
            })
            $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                });
          }
          else {
            $.post("upload.php" , {indexWord}, function(data) {
              if(data.length == 11) {
               $("#gallery").append('');
               document.getElementById("gallery").innerHTML = '';
               document.getElementById("loadMore").setAttribute("style", " display: none;");
              }
                
              else {
                document.getElementById("gallery").innerHTML = '';
                var data = JSON.parse(data);
                document.getElementById("loadMore").setAttribute("style", "display: none;");
                for(var j = 0 ; j < data.length ; j++) {
                  var insertDiv = "<div id='"+data[j].fileurl+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url("+data[j].fileurl+"); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>";
                  $("#gallery").append(insertDiv);
                }
              }
            });
          }
        });

        // when click imguploadbtn, zipuploadbtn click
        $("#imguploadbtn").click(function() {
          document.getElementById("imguploadbtn").setAttribute("style", "border: 1px solid black;");
          document.getElementById("zipuploadbtn").setAttribute("style", "border: none ;");
          document.getElementById("imauploaddiv").setAttribute("style", "display: block;");
          document.getElementById("zipForm").setAttribute("style", "display: none; ");
          document.getElementById("zipResult").setAttribute("style", "display: none;");
        })
        $("#zipuploadbtn").click(function() {
          document.getElementById("zipuploadbtn").setAttribute("style", "border: 1px solid black;");
          document.getElementById("imguploadbtn").setAttribute("style", "border: none ;");
          document.getElementById("imauploaddiv").setAttribute("style", "display: none;");
          document.getElementById("zipForm").setAttribute("style", "display: block; ");  
          document.getElementById("zipResult").setAttribute("style", "display: block;");
        })

        // when click delete permanantly a 
        $("#deleteImg").click(()=>{
          var curId = document.getElementById("curimageurl").value;
          prediv = null;
          clickflag = 0;
          document.getElementById('mySidenav').style.width = 0 + 'px';
          document.getElementById(curId).remove();
          $.post("upload.php" , {id: curId , delete: "true"} , function(data) {

          });
          $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                    else {
                      document.getElementById("loadMore").setAttribute("style", "display: none;");
                    }
                });
        });
        // when sidenavbar click , process image
        $("#editImage").on("click", function(e) {
              var modal = document.getElementById("myModal");
              var span = document.getElementsByClassName("close")[0];

              modal.style.display = "block";

              span.onclick = function() {
                modal.style.display = "none";
              }

              window.onclick = function(event) {
                if (event.target == modal) {
                  modal.style.display = "none";
                }
              }
              var Image = document.getElementById("curimageurl").value;
              var editor = document.getElementById("editor");
              var modalBody = document.getElementById("modalBody");
              if(curimagewidth > curimageheight)
                modalBody.style.height = curimagewidth + 200 + 'px';
              else
                modalBody.style.height = curimageheight + 200 + 'px';
              editor.style.width = curimagewidth + 'px';
              editor.style.height = curimageheight + 'px';

              editor.style.top = 0 + 'px';
              editor.style.left = 0 + 'px';
              editor.style.backgroundImage = "url('"+Image+"')";
              
        });

        // when click copy url btn
        $("#copyurlbtn").click(()=>{
          var copyText = document.getElementById("curimageurl");
          copyText.select();
          copyText.setSelectionRange(0, 99999); 
          navigator.clipboard.writeText(copyText.value);  
          document.getElementById("mySidenav2").style.width = "300px";
          setTimeout(function(){
            document.getElementById("mySidenav2").style.width = "0";
          },2000);
        })

        // when change audio type dropdown list
        $("#typeMediafilter").change((e)=>{
          document.getElementById('gallery').innerHTML = '';
          var mediaType = e.target.value;

             $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                    else
                      document.getElementById("loadMore").setAttribute("style" , "display: none; ");
                });
          
          $.post("upload.php" , {mediaType} , function(data) {
            
            if(data.indexOf("0 result") != -1) {
              
            }
            else {
              var data = JSON.parse(data);
              for(var i = 0 ; i < data.length ; i++) {
                $("#gallery").append("<div id='"+data[i].fileurl+"' style='display: inline-block; margin-right: 10px; margin-bottom: 10px;  background-image: url(" + data[i].fileurl + "); background-position: center;  background-repeat: no-repeat; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.3); background-size: cover; position: relative; width:100px ; height: 100px;'></div>");

              }
                $.post("upload.php", {getRow:"true"}, function(data) {
                    totalUploadImageCnt = data;
                    if (totalUploadImageCnt > 27) {
                      document.getElementById("loadMore").setAttribute("style","display: block;");
                    }
                    else
                      document.getElementById("loadMore").setAttribute("style" , "display: none; ");
                });
            }
          });
        });


        // image resize btn click

        $("#img_resize_btn").click(() => {
          var imageWidth = document.getElementById("img_resize_width").value,
              imageHeight = document.getElementById("img_resize_height").value;
          document.getElementById("editor").style.width = imageWidth + 'px';
          document.getElementById("editor").style.height = imageHeight + 'px';
        });

        // image rotate Left click
        $("#rotateL").click(()=>{
          rotateLeftflag += 1;
          var value = rotateLeftflag * 90;
          var delta = 0;
          var image = document.getElementById("editor");
          var curwidth = parseInt(image.style.width);
          var curheight = parseInt(image.style.height);
          console.log("curwidth  " + curwidth + "  curheight  " + curheight);
          image.style.transform = 'rotate(-' + value + 'deg)';
          if(curwidth > curheight) {
            delta = (curwidth - curheight) / 2;
            image.style.top = delta + 'px';
            image.style.left = 0;
          }
          else {
            delta = (curheight - curwidth) / 2;
            image.style.top = 0 + 'px';
            image.style.left = delta + 'px';
          }

        });

        // when image rotate right click
        $("#rotateR").click(()=>{
          rotateRightflag += 1;
          var value = rotateRightflag * 90;
          var delta = 0;
          var image = document.getElementById("editor");
          var curwidth = parseInt(image.style.width);
          var curheight = parseInt(image.style.height);
          image.style.transform = 'rotate(' + value + 'deg)';
          if(curwidth > curheight) {
            delta = (curwidth - curheight) / 2;
            image.style.top = delta + 'px';
            image.style.left = 0;
          }
          else {
            delta = (curheight - curwidth) / 2;
            image.style.top = 0 + 'px';
            image.style.left = delta + 'px';
          }
        });

        // when click image edit save btn
        $("#editSave").click(()=> {
          html2canvas(document.getElementById("editor")).then(function (canvas) {      
            var anchorTag = document.createElement("a");
            document.body.appendChild(anchorTag);
            var originname = document.getElementById("curimagename").value;
            originname = originname.slice(0, originname.indexOf("."));
            var addnum = parseInt(Math.random() * (30000 - 10000) + 10000);
            originname = originname + addnum + '.jpg';
            anchorTag.download = originname;
            anchorTag.href = canvas.toDataURL();
            anchorTag.target = '_blank';
            anchorTag.click();
          });
          setTimeout(function() {
            document.getElementById("editor").style.top = 0 + 'px';
            document.getElementById("editor").style.left = 0 + 'px';
            window.location.href = "/";
          }, 3000);
        });
      });
    

    </script>
  </body>
</html>
