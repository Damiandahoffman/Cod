$(document).bind('flagGlobalAfterLinkUpdate', function(event, data) {
	
	var id = data.contentId;
	if (data.flagStatus=='flagged')
		{
		$('td#'+id).addClass('cellhighlight'); 
		}
	else
		{
		$('td#'+id).removeClass('cellhighlight');
		}
	
	var numItems = $('.cellhighlight').length
	$("span.total").html("("+numItems+")");
	
	$.get( "cod/basket", function( data ) {
		document.getElementById('view_block').innerHTML=data
	});
		$.get( "basket", function( data ) {
		document.getElementById('view_block').innerHTML=data
	});

});
		
	


	