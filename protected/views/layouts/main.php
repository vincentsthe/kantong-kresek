<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html>
<head>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css" media="screen">
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	
	<!-- Javascript -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/jquery.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/bootstrap.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<!-- Header -->
	<div class="header container-fluid">
		<div class="branding">
			<div class="row">
				<h1 class="col-md-10">Kantong-Kresek</h1>
				<h2 class="col-md-10">Mangga Dua Mall Lantai 5 Blok C117</h2>
			</div>
		</div>
	</div>
	<div class="navbar navbar-inverse" style="padding:0px;margin-bottom: 0px;">
		<div class="container navbar-menu">
			<ul class="nav navbar-nav">
				<li><?php echo CHtml::link("Penjualan", array('invoicePenjualan/createNew'));?></li>
				<?php if(!Yii::app()->user->isGuest && Yii::app()->user->roles == 'admin'): ?>
					<li><?php echo CHtml::link("Pembelian", array('invoicePembelian/create'));?></li>
					<li><?php echo CHtml::link("User", array('user/index'));?></li>
					<li><?php echo CHtml::link("Inventarisasi", array('inventory/index'));?></li>
					<li><?php echo CHtml::link("Tunggakan", array('tunggakan/index'));?></li>
					<li><?php echo CHtml::link("Absen", array('absen/list'));?></li>
					<li><?php echo CHtml::link("Administrasi", array('accounting/index'));?></li>
				<?php endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if(!Yii::app()->user->isGuest):?>
					<li><a style="color:red"><?php echo Cabang::model()->findByPk(Yii::app()->user->location)->nama; ?></a></li>
					<li><a><?php echo Yii::app()->user->name;?>, </a></li>
					<li><?php echo CHtml::link("Logout", array('site/logout'))?></li>
				<?php endif;?>
			</ul>
		</div>
	</div>

	<div class="container content">
		<?php echo $content; ?>
	</div>

	<div class="clear"></div>

	<div class="modal-footer footer">
		<div class="container">
			<h4>&#169 2014 Kantong Kresek</h4>
		</div>
	</div><!-- footer -->

</body>
</html>