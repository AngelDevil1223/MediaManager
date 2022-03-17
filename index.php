<!DOCTYPE html>
<html>
<head>
	<title>Media Manager</title>
	<link rel="stylesheet" type="text/css" href="./assets/custom.css">
</head>
<body>
	<div class="container">
		<div class="left_sidebar">
			<div class="left_sidebar_actions">
				<p class="left_sidebar_a">All</p> 	 
				<p class="left_sidebar_a">Home</p>  
				<p class="left_sidebar_a">Products</p> 
				<p class="left_sidebar_a">Site</p> 
				<p class="left_sidebar_a">Categories</p>
				<p class="left_sidebar_a">Banners</p>
			</div>
			<div class="left_sidebar_inserturl">
				
			</div>
		</div>
		<div class="content">
			<div class="content_header">
				<h3>Add Media</h3>	
			</div>
			<div class="content_content">
				<div class="tabset">
				  <!-- Tab 1 -->
				    <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
				    <label for="tab1">Upload files</label>
				  <!-- Tab 2 -->
				    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
				    <label for="tab2">Media Library</label>
				  	<div class="import_url">
				  		Import from URL
				  	</div>
				    <div class="expand_detial" >
				  	    <button class="detail_btn" id="detail_btn" onclick="openNav();"> < 
				  	    </button>
				  	    <label id="detail_label" >Expand Details</label>
				    </div>
				 <div class="tab-panels">
				    <section id="marzen" class="tab-panel">
				       <h2>Tab1</h2>
				       <p>tab1</p>
				    </section>
				    <section id="rauchbier" class="tab-panel">
					    <div class="mediatab_filter_div">
						    <div class="mediatab_select_div">
						    	<h5>Filter media</h5>
						     	<select class="items_select">
						    		<option>All media items</option>
						    	</select>
						    	<select class="dates_select">
						    		<option>All dates</option>
						    	</select>
						    </div>
						    <div class="mediatab_index_div">
						    	<label class="index_label">Search</label><br />
						    	<input class="index_input" />
						    </div>
					    </div>
					    <div class="gallery" id="gallery">
					    </div>
					</section>
				</div>
			</div>
			<div id="mySidepanel" class="sidepanel">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav();">×</a>
				<p class="sidepanel_header">ATTACHMENT DETAILS</p>
				<div class="sidepanel_detail">
					<div class="sidepanel_detail_img">
					</div>
					<div class="sidepanel_detail_info" >
						<input class="detail_info_input bold_input" type="" name="" value="image1.jpg" id="img_name" />
						<input class="detail_info_input" value="Janury 1 2020" id="img_date" />
						<input class="detail_info_input" value="1.3 MB" id="img_capacity" />
						<input class="detail_info_input" value="1440 by 1440px" id="img_dimention" />
					</div>
				</div>
				<div class="sidepanel_edit">
					<div class="sidepanel_edit_section1">
						<label class="sidepanel_label">Alt Text</label>
						<input class="sidepanel_input" />
					</div>
					<div class="sidepanel_edit_section2">
						<p id="describe_p"><strong id="describe_a">Describe the purpose of the image.</strong> Leave <br /> empty if the image is purely decorative.</p>
					</div>
					<div class="sidepanel_edit_section3">
						<label class="sidepanel_label">Title</label>
						<input type="" name="" class="sidepanel_input" />
					</div>
					<div class="sidepanel_edit_section4">
						<div class="section4_div1">Caption</div>
						<div class="section4_div2">
							<textarea class="textarea1"></textarea>
						</div>
					</div>
					<div class="sidepanel_edit_section5">
						<div class="section4_div1 section5_div1">Description</div>
						<div class="section4_div2 section5_div2">
							<textarea class="textarea1 textarea2"></textarea>
						</div>
					</div>
					<div class="sidepanel_edit_section6">
						<label class="sidepanel_label">File URL: </label>
						<input class="sidepanel_input"/>
					</div>
					<button class="sidepanel_copybtn">Copy URL to clipboard</button>
				</div>
				<div class="sidepanel_option">
					<p class="option_header">This option will show where applicable</p>
					<p class="option_content">ATTACHMENT DISPLAY SETTINGS</p>
					<div class="sidepanel_option_section">
						<label class="option_label">Alignment</label>
						<select class="option_select">
							<option>Centre</option>
						</select>
					</div>
					<div class="sidepanel_option_section sidepanel_option_section1">
						<label class="option_label">Link To</label>
						<select class="option_select">
							<option>Media File</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="./assets/custom.js"></script>
</body>
</html>