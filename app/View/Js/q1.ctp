<div class="alert  ">
   <button class="close" data-dismiss="alert"></button>
   Question: Advanced Input Field
</div>
<p>
   1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.
</p>
<p>
   2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field
   <?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]
</p>
<div class="alert alert-success">
   <button class="close" data-dismiss="alert"></button>
   The table you start with
</div>
<table class="table table-striped table-bordered table-hover">
   <thead>
      <th width="20%"><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
         <i class="icon-plus"></i></span>
      </th>
      <th width="40%">Description</th>
      <th width="20%">Quantity</th>
      <th width="20%">Unit Price</th>
   </thead>
   <tbody>
      <tr>
        <td></td>
        <td>
		 	<p id="desc-label1">Sample Text</p>
			<textarea name="data[1][description]" class="m-wrap description required" rows="2" onkeyup="copyData(this,'desc-label1')" >Sample Text</textarea>
		</td>
		<td>
			<p id="qty-label1">1</p>
			<input name="data[1][quantity]" class="" value="1" onkeyup="copyData(this,'qty-label1')">
		</td>
		<td>
			<p id="unitprice-label1">1000</p>
			<input name="data[1][unit_price]"  class="" value="1000" onkeyup="copyData(this,'unitprice-label1')">
		</td>
      </tr>
   </tbody>
</table>
<p></p>
<div class="alert alert-info ">
   <button class="close" data-dismiss="alert"></button>
   Video Instruction
</div>
<p style="text-align:left;">
   <video width="78%"   controls>
      <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
      Your browser does not support the video tag.
   </video>
</p>

<?php $this->start('script_own');?>
<script>
   $(document).ready(function(){

		let count = 1;
		$("td textarea, td input").hide();
		$("#add_item_button").click(function(){
			count++;
			let newRow = `<tr>
							<td></td>
							<td>
								<p id="desc-label${count}"></p>
								<textarea name="data[${count}][description]" class="m-wrap description required" rows="2" onkeyup="copyData(this,'desc-label${count}')" ></textarea>
							</td>
							<td>
								<p id="qty-label${count}"></p>
								<input name="data[${count}][quantity]" class="" onkeyup="copyData(this,'qty-label${count}')">
							</td>
							<td>
								<p id="unitprice-label${count}"></p>
								<input name="data[${count}][unit_price]" class="" onkeyup="copyData(this,'unitprice-label${count}')">
							</td>
						</tr>`;
			$("tbody").append(newRow);
		});
		
		$("body").on('click', function(e) {
			console.log(e.target);
			if (!$( e.target ).is("input, textarea, td, p")) {
				hideComponents();
				$("p").show();
			}
		});

		// setInterval(function(){
			$('table').on("click", "td", function(e) {
				if ($( e.target ).is("input, textarea")) {
					return;
				} else if ($(this).hasClass('selected')) {
					$("td.selected p").show();
					hideComponents();
				} else {
					hideComponents();
					$(this).addClass('selected');
					$("td p").show();
					$('td.selected input, td.selected textarea').show();
					$("td.selected p").hide();
					$("td.selected input, td.selected textarea").focus();
				}
			});
		// }, 1);
	
		
		function hideComponents() {
			$("td textarea, td input").hide();
			$("td").removeClass("selected");
		}
   });

   function copyData(el, targ) {
		document.getElementById(targ).innerHTML = el.value;
	}
</script>
<?php $this->end();?>