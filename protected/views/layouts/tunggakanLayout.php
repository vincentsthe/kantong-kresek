<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Tunggakan
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><?php echo CHtml::link("Daftar", array('tunggakan/index'))?></li>
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>