<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Stok
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar", array('inventory/index'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "stock"):?>class="active"<?php endif;?>><?php echo CHtml::link("Ringkasan Stock", array('inventory/listStok'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "list"):?>class="active"<?php endif;?>><?php echo CHtml::link("Register Barang", array('inventory/listUnspecified'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "pindah"):?>class="active"<?php endif;?>><?php echo CHtml::link("Pindahkan Barang", array('inventory/pindah'))?></li>
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>