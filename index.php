
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Media Manager</title>

    <link rel="canonical" href="https://www.phplift.net/" />
    <link rel="publisher" href="https://plus.google.com/104843303742341697879" />
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

      /* Absolute Center Spinner */
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

      /* Transparent Overlay */
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
            <a class="active" id="a1" onclick="tab(1)">Drag and Drop</a>
            <a id="a2" onclick="tab(2)">From URL</a>
            <a id="a3" onclick="tab(3)">From embed</a>
            <a id="a4" onclick="tab(4)">Media Library</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="content_body" id="tab1">
          <div class="loading d-none"><img src="load.gif" alt="" /></div>
          <div id="ddArea">
            Drag and Drop Files Here or
            <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
              Select File(s)
            </a>
          </div>
          <div id="showThumb"></div>
          <input type="file" class="d-none" id="selectfile" multiple />
        </div>
        <div class="content_body" id="tab2">
          <h3>From URL</h3>
        </div>
        <div class="content_body" id="tab3">
          <h3>From Embed </h3>
        </div>
        <div class="content_body" id="tab4">
        </div>    
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      var url;
      var embed1 = [];
      var totallegnth;
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

                  embed1[j] = '<div style="background-image:url(uploads/' + data[j] + '); opacity: 1; background-position: center;  background-repeat: no-repeat; background-size: cover; position: relative; box-shadow:0px 6px 6px 0px rgba(0, 0, 0, 0.4);" class="thumbnail"><img style="position: absolute; width: 30px; height: 30px; top: 33px; left: 33px;" src="tick.png" /></div>';
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
    </script>
  </body>
</html>
