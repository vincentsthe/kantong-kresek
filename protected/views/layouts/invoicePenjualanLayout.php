<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-3 col-xs-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Invoice Penjualan
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<?php if(Yii::app()->user->roles == 'admin'): ?>
					<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar", array('invoicePenjualan/index'))?></li>
				<?php endif; ?>
				<li <?php if(isset($this->active) &&  $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Terbitkan Invoice", array('invoicePenjualan/createNew'))?></li>
				<?php if(Yii::app()->user->roles == 'admin'): ?>
					<li <?php if(isset($this->active) &&  $this->active == "report"):?>class="active"<?php endif;?>><?php echo CHtml::link("Laporan", array('invoicePenjualan/report'))?></li>
				<?php endif; ?>
				<li <?php if(isset($this->active) &&  $this->active == "today"):?>class="active"<?php endif;?>><?php echo CHtml::link("Penjualan Hari Ini", array('invoicePenjualan/listToday'))?></li>
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 col-xs-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>