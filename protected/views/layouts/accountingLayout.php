<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Administrasi
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar", array('accounting/index'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat Baru", array('accounting/create'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "listCode"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar Kode", array('accounting/listCode'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "newCode"):?>class="active"<?php endif;?>><?php echo CHtml::link("Kode Baru", array('accounting/newCode'))?></li>
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>