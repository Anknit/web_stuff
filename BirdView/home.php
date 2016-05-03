<?php
?>
<html>
	<head>
		<link href="./home.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id='sourceBlock'>
			<div class='container_drag'>
				<div id='content_div' class='main_drag' cloneOnDrop='true' draggable='true' ondragstart="drag(event)">DIV element</div>
			</div>
			<div class='container_drag'>
				<input type='text' id='content_input' class='main_drag' cloneOnDrop='true' draggable='true' ondragstart="drag(event)" placeholder='Text Input'/>
			</div>
			<div class='container_drag'>
				<input type='button' id='content_button' class='main_drag' cloneOnDrop='true' draggable='true' ondragstart="drag(event)" value='Button'/>
			</div>
		</div>
		<div id='PageBlock' ondrop="drop(event)" ondragover="allowDrop(event)">
		<div id="content_divcloned_Page1420781354772" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 8px; left: 146px; width: 401px; height: 512px;">DIV element<div id="content_divcloned_Page1420781440712" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 134px; left: 195px; height: 364px; width: 308px;">DIV element<input type="text" id="content_inputcloned_Page1420781471922" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" placeholder="Text Input" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 270px; left: 253px;"><input type="text" id="content_inputcloned_Page1420781497569" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" placeholder="Text Input" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 321px; left: 254px;"><input type="button" id="content_buttoncloned_Page1420781502584" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" value="Button" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 377px; left: 296px; margin: 0px; width: 98px; height: 26px;"><div id="content_divcloned_Page1420781511929" class="main_drag" cloneondrop="false" draggable="true" ondragstart="drag(event)" style="resize: both; overflow: auto; position: fixed; cursor: auto; top: 175px; left: 231px; width: 235px; height: 43px;">DIV element</div></div></div>		
		</div>
<button onclick="create_openDB()">Create or Open IndexedDB</button>
		<textarea id='textentryDB'></textarea>
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="./home.js"></script>
	</body>
</html>