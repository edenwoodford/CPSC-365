	
	$(document).ready(function ()
	{
	$('#addActorB').click(function()
	{ 
	$('<p><input type= "text" name = "actor[]"></p>').insertAfter ('#addActor:last');
});
	});
