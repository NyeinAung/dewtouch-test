
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type', 'url' => '/format/q1_answer', 'type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(

				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
		'Type1' => __("<span class='mouseover' data-id='1' style='color:blue' data-bind='mouseover_1' data-content='<span style=\"display:inline-block\"><ul><li>Description .......</li><li>Description 2</li></ul></span>'>Type1</span>"),
		'Type2' => __("<span class='mouseover' data-id='2' style='color:blue' data-bind='mouseover_2' data-content='<span style=\"display:inline-block\"><ul><li>Desc 1 .....</li><li>Desc 2...</li></ul></span>'>Type2</span>")
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<br><br>
<?php
	echo $this->Form->input('type', array('class' => 'selected-result', 'type' => 'hidden', 'name' => 'selected', 'value' => ''));
	echo $this->Form->submit('Save', array('class' => 'btn btn-primary btn-save', 'style' => 'display:none;'));
?>
<?php echo $this->Form->end();?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	$(".dialog").dialog({
		autoOpen: false,
		width: '500px',
		modal: true,
		dialogClass: 'ui-dialog-blue'
	});

	$(".showDialog").click(function(){ var id = $(this).data('id'); $("#"+id).dialog('open'); });

	$(".btn-save").hide();
	var isVisible = false;

	$(".mouseover").popover({
		trigger: 'manual',
		html: true
	}).click(function(e) {
		let id = $(this).data("id");

		if(isVisible) {
            $('.mouseover').each(function() {
				if(id != $(this).data("id")) {
					$(this).popover('hide');
				}
      	 	});
        }
		
		$(this).popover('show');
		$(".selected-result").val($(this).data("content"));

		isVisible = true;
		$(".btn-save").show();
        e.stopPropagation();

	});

	$(".radio").click(function(){
		$(this).find(".mouseover").click();
	});
})


</script>
<?php $this->end()?>