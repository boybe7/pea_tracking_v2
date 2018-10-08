<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pj_id),array('view','id'=>$data->pj_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_code')); ?>:</b>
	<?php echo CHtml::encode($data->pj_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_name')); ?>:</b>
	<?php echo CHtml::encode($data->pj_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->pj_vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_work_cat')); ?>:</b>
	<?php echo CHtml::encode($data->pj_work_cat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_fiscalyear')); ?>:</b>
	<?php echo CHtml::encode($data->pj_fiscalyear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_date_approved')); ?>:</b>
	<?php echo CHtml::encode($data->pj_date_approved); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_details')); ?>:</b>
	<?php echo CHtml::encode($data->pj_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_user_create')); ?>:</b>
	<?php echo CHtml::encode($data->pj_user_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pj_user_update')); ?>:</b>
	<?php echo CHtml::encode($data->pj_user_update); ?>
	<br />

	*/ ?>

</div>