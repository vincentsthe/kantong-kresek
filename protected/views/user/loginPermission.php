<?php
/* @var $this UserController */
/* @var $loginPermission Map<CabangName, User[]> */
?>

<h1>Izin Login</h1>
<hr>
<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success">
		<?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif;?>

<?php echo CHtml::link('Buat Izin Baru', array('user/createPermission'), array('class'=>'btn btn-warning pull-left')); ?>
<br><br><br><br>

<?php foreach($loginPermission as $cabangName=>$listUser): ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4><?php echo $cabangName; ?></h4>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th>Username</th>
					<th>Fullname</th>
					<th></th>
				</tr>
				<?php foreach($listUser as $user): ?>
					<tr>
						<td><?php echo $user->username; ?></td>
						<td><?php echo $user->fullname; ?></td>
						<td><?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array('user/removePermission', 'userId'=>$user->id, 'cabangName'=>$cabangName)); ?></td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>
	</div>
<?php endforeach; ?>