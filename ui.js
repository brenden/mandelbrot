$(document).ready(function() {

	$("#help-icon").click(

		function(event) {
	
			if ($("#help-icon").html()=="?") {

				$("#information").show();
				$("#help-icon").html("X");
			}
			else {
		                $("#information").hide();
                                $("#help-icon").html("?");
			}
		}
	);

	$("#clear").click(

		function(event) {

			event.preventDefault();
                        window.open("index.php", "_self");
		}
	);

	$("rect").click(

		function(event) {

			var real = $("#"+event.target.id).attr("data-real");
			var imaginary = $("#"+event.target.id).attr("data-imaginary");
                        var bsize = $("#"+event.target.id).attr("data-bsize");
			window.open("index.php?real="+real+"&imaginary="+imaginary+"&bsize="+bsize, "_self");	
		}
	);

	$("rect").mouseover(

		function(event) { 

                	$("#"+event.target.id).css("opacity", ".5");
		}
	);

        $("rect").mouseout(

                function(event) { 

                        $("#"+event.target.id).css("opacity", "1");
                }
        );
});

