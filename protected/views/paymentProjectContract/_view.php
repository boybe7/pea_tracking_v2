<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proj_id')); ?>:</b>
	<?php echo CHtml::encode($data->proj_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detail')); ?>:</b>
	<?php echo CHtml::encode($data->detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('money')); ?>:</b>
	<?php echo CHtml::encode($data->money); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_no')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_date')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_no')); ?>:</b>
	<?php echo CHtml::encode($data->bill_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_date')); ?>:</b>
	<?php echo CHtml::encode($data->bill_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_create')); ?>:</b>
	<?php echo CHtml::encode($data->user_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_update')); ?>:</b>
	<?php echo CHtml::encode($data->user_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_update')); ?>:</b>
	<?php echo CHtml::encode($data->last_update); ?>
	<br />

	*/ ?>

</div>