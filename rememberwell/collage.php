<!DOCTYPE html>
<?php 
	session_start();
	$mem_id = $_GET['mem_id'];
	include('includes/mysqli_connect.php');
	$q = "SELECT * FROM collage WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row = mysqli_fetch_array($r)) {
		$nodes = $row['nodes'];
	}
	$nodes = json_decode($nodes);
	foreach($nodes as $node) { 
			$xaxis[]=$node[0];
			$yaxis[]=$node[1];
			$src[]=$node[2];
	}
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<title>Purchase Memorials</title>";
?>
<script src='includes/jquery-1.7.2.min.js'></script>
<script src='includes/jquery-ui-1.8.21.custom.min.js'></script>
<script src='includes/jquery.ui.core.js'></script>
<script src='includes/jquery.ui.draggable.js'></script>
<script src='includes/jquery.ui.droppable.js'></script>
<script src='includes/jquery.ui.mouse.js'></script>
<script src='includes/jquery.ui.widget.js'></script>
	<script>
	$(document).ready(function(){
		$('div.collagedelete').fadeTo(200,0.5);
		var xaxis = <?php echo json_encode($xaxis) ?>;
		var yaxis = <?php echo json_encode($yaxis) ?>;
		var nodeSrc = <?php echo json_encode($src) ?>;
		var mem_id = <?php echo $mem_id ?>;
		var dropElement;
		var xPos;
		var yPos;
		var delFade = function(){
			var numClick =	$('img.clicked').length;
				if(numClick==0){
					$('div.collagedelete').fadeTo(200,0.5);
				} else {
					$('div.collagedelete').fadeTo(200,1.0);
				}
		};
		var itemClick = function() {
			$('img.canvas').off('click');
			$('img.canvas').click(function(){
				if($(this).hasClass('noclick')){
					$(this).removeClass('noclick');
				} else {
				$(this).toggleClass('clicked');
				var relPos = $(this).position();
				delFade();	
				}
			});
		};
		$('div.canvas').droppable({accept:'.drag',drop:function(event,ui) {
		dropElement = $(ui.helper.clone());
		var pos = ui.offset;
		xPos = pos.left;
		yPos = pos.top;
		var canPos = $('div.canvas').offset();
		canX = canPos.left;
		canY = canPos.top;
		xPos = xPos - canX;
		yPos = yPos - canY;	
		dropElement = dropElement.addClass('canvas');
		dropElement.appendTo($(this));
		dropElement.css('left',xPos);
		dropElement.css('top',yPos);
		$('img.canvas').removeClass('drag');
		$('img.canvas').draggable({
			stack:'.canvas',
			cursor:'pointer',
			containment:'parent',
			start: function(event,ui) {
				$(this).addClass('noclick');
			}
		});
		itemClick();

	}});
	$('img.drag').draggable({
		helper: 'clone',
		appendTo:'div.canvas'
	});
	$('img.canvas').draggable({
			stack:'.canvas',
			cursor:'pointer',
			containment:'parent',
			start: function(event,ui) {
				$(this).addClass('noclick');
			}
		});

		itemClick();
	$('div.collagedelete').click(function(){
		$('img.clicked').remove();
		delFade();	
	});
	$('div.collagesave').click(function(){
		var nodes = [];
		$('img.canvas').each(function(){
			nodes.push([$(this).css('top'),$(this).css('left'),$(this).attr('src')]);
		});
		$.post('savecollage.php',{nodes:nodes,mem_id:mem_id},function(data){
			alert(data);
		});
	});
		for(i=0;i<nodeSrc.length;i++) {
			var newNode = "<img src='"+nodeSrc[i] + "' class='curnode' />";
			$('div.canvas').append(newNode);
			$('img.curnode').css('left',xaxis[i]);
			$('img.curnode').css('top',yaxis[i]);
			$('img.curnode').addClass('canvas');
			$('img.curnode').removeClass('curnode');
		}
	itemClick();

	});
</script>


<?php
	echo "	</head>
		<body>";
	include('logobar.php');
	echo "<section class='reliquary'>
		<div class='canvas' id='canvas'>
		</div>";

	echo "<div class='collagedelete'>
		<p>delete selected items</p>
		</div>";
	echo "<div class='collagesave'>
		<p>save collage</p>
		</div>
		</section>";

	echo "<section class='items'>";
echo "<span class='items'>";
	foreach (scandir('offerings') as $offering) {
		if($offering!='.' && $offering!='..'){
		echo "<div class='thisoffer'>";
		echo "<img src='offerings/$offering' class='drag' />";
		echo "</div>";
		}
	}
	echo "</span>
		</section>";

	echo "
		</body>
		</html>";
?>


