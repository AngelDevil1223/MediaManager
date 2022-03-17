var gallery = document.getElementById("gallery");
var imgurl = [
	"../assets/imgs/food1.png",
	"../assets/imgs/food2.png",
	"../assets/imgs/food3.png",
	"../assets/imgs/food4.png",
	"../assets/imgs/food5.png",
	"../assets/imgs/food6.png",
	"../assets/imgs/food7.png",
	"../assets/imgs/food3.pdf",
	"../assets/imgs/food8.png",
	"../assets/imgs/food9.png",
	"../assets/imgs/food10.png",
	"../assets/imgs/food11.png",
	"../assets/imgs/food12.png",
	"../assets/imgs/food13.png",
	];
init();



function init() {
	for (var i = 0; i < 50 ; i++) {
		var j = i % 14;
		if(imgurl[j].slice(-3) == "png") {
			gallery.innerHTML += "<div style=\"box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.3); width: 100px; margin:5px; height: 100px; background-image: url("+imgurl[j]+"); background-size: cover;	background-repeat: no-repeat; background-position: center center; +\" ></div>";
		}
		else if(imgurl[j].slice(-3) == "pdf") {
			gallery.innerHTML += "<iframe src="+imgurl[j]+" scrolling=\"hidden+\" style=\"box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.3); width: 95px; margin:5px; height: 95px; +\" ></iframe>";
		}
	}
}

function openNav() {
  document.getElementById("mySidepanel").style.width = "400px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}