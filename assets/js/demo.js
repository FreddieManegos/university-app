$(document).ready(function() {

	$('#search_text_input').focus(function(){
		if(window.matchMedia('(min-width:800px').matches){
			$(this).animate({width:'300px'},500);
		}
	}); // This will expand the text bar

	$('.button_holder').on('click',function(){
		document.search_form.submit();
	});
	//Button for profile post

	$('#submit_profile_post').click(function(){
		
		$.ajax({
			type: "POST",
			url: "includes/handlers/ajax_submit_profile_post.php",
			data: $('form.profile_post').serialize(),
			success: function(msg) {
				$("#post_form").modal('hide');
				location.reload();
			},
			error: function() {
				alert('Failure');
			}
		});

	});


});


function getCourse(value, user) {
	$.post("includes/handlers/ajax_search_course.php", {query:value, userLoggedIn:user}, function(data) {
		$(".results").html(data);
	});
}

function getUsers(value, user) {
	$.post("includes/handlers/ajax_search.php", {query:value, userLoggedIn:user}, function(data) {
		$(".results").html(data);
	});
}

// function getLiveSearchCourse(value){
// 	$.post("includes/handlers/ajax_search.php", {query:value},function(data){
// 		if($(".search_results_footer_empty")[0]) {
// 			$(".search_results_footer_empty").toogleClass("search_results_footer");
// 			$(".search_results_footer_empty").toogleClass("search_results_footer_empty");
// 		}

// 		$('.search_results').html(data);
// 		$('.search_results_footer').html("<a href='seach.php?q='"+value+"'>See All Results</a>");

// 		if(data= ""){
// 			$('.search_results_footer').html("");
// 			$('.search_results_footer').toogleClass("search_results_footer_empty");
// 			$('.search_results_footer').toogleClass("search_results_footer");
// 		}
// 	});
// }

function getLiveSearchUsers(value, user){
		$.post("includes/handlers/ajax_search.php", {query:value, userLoggedIn: user},function(data){
		if($(".search_results_footer_empty")[0]) {
			// $(".search_results_footer_empty").toogleClass("search_results_footer");
			// $(".search_results_footer_empty").toogleClass("search_results_footer_empty");
		} 

		$('.search_results').html(data);
		$('.search_results_footer').html("<a href='search.php?q='"+value+">See All resultsults</a>");
		
		if(data= ""){
			$('.search_results_footer').html("");
			$('.search_results_footer').toogleClass("search_results_footer_empty");
			$('.search_results_footer').toogleClass("search_results_footer");
		}
	});
}