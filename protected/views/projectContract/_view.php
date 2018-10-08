<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pc_id),array('view','id'=>$data->pc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_code')); ?>:</b>
	<?php echo CHtml::encode($data->pc_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_proj_id')); ?>:</b>
	<?php echo CHtml::encode($data->pc_proj_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->pc_vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_sign_date')); ?>:</b>
	<?php echo CHtml::encode($data->pc_sign_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->pc_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_cost')); ?>:</b>
	<?php echo CHtml::encode($data->pc_cost); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_T_percent')); ?>:</b>
	<?php echo CHtml::encode($data->pc_T_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_A_percent')); ?>:</b>
	<?php echo CHtml::encode($data->pc_A_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_guarantee')); ?>:</b>
	<?php echo CHtml::encode($data->pc_guarantee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_user_create')); ?>:</b>
	<?php echo CHtml::encode($data->pc_user_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_user_update')); ?>:</b>
	<?php echo CHtml::encode($data->pc_user_update); ?>
	<br />

	*/ ?>

</div>