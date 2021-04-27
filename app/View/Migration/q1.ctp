<div>


<?php echo $this->Form->create('Type',array('id'=>'form_type', 'url' => '/migration/q1_answer', 'type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(

				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please click below button to migrate:")?>
<br><br>
<?php
	echo $this->Form->submit('Migrate', array('class' => 'btn btn-primary'));
?>
<?php echo $this->Form->end();?>

</div>