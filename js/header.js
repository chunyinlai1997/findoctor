/*jQuery.noConflict();
$(document).ready(function(){
	var int = 0;
	$.ajax({
		url:"token.php",
		method:"POST",
		data:{get:int},
		success:function(data)
		{
			$.ajax({
			url:"header.php",
			method:"POST",
			data:{generate:data},
			success:function(data)
			{
				$('#headprint').html(data);
			}
		 });
		}
	});
});
*/