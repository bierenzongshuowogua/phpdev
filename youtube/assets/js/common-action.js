$(document).ready(function(){
	$(".nav-show-hide").on("click",function(){
		var main=$("#main-section-container");
		var nav = $("#side-nav-container");
		if(main.hasClass("paddingleft")){
			nav.hide();
		}else {
			nav.show();
		}
		main.toggleClass("paddingleft");
	});
	//$(".comment-reply").on("click",function(){
	//	alert(234);
	//)};
	$(".mycollection").click(function(){
	});
});

/*
likeVideo=function(){
	alert("123");
}
*/
/*
//$(document).ready(function(){
$(document).ready(function(){
	$(".nav-show-hide").on("click",function(){
		var main=$("#main-section-container");
		var nav = $("#side-nav-container");
		if(main.hasClass("paddingleft")){
			nav.hide();
		}else{
			nav.show();
		}
		main.toggleClass("paddingleft");
	})
});
*/
