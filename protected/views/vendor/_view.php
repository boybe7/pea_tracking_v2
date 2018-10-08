<div class="view span8">

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->v_id),array('view','id'=>$data->v_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_name')); ?>:</b>
	<?php echo CHtml::encode($data->v_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_address')); ?>:</b>
	<?php echo CHtml::encode($data->v_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_tax_id')); ?>:</b>
	<?php echo CHtml::encode($data->v_tax_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_tel')); ?>:</b>
	<?php echo CHtml::encode($data->v_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_contractor')); ?>:</b>
	<?php echo CHtml::encode($data->v_contractor); ?>
	<br />


</div>