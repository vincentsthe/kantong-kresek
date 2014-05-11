<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Invoice Pembelian
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar", array('invoicePembelian/index'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Terbitkan Invoice", array('invoicePembelian/create'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "report"):?>class="active"<?php endif;?>><?php echo CHtml::link("Laporan", array('invoicePembelian/report'))?></li>
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>