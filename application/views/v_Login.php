  <?php
    require("header.php");
?>
<link href="<?= base_url("assets/css/main.css")?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/util.css")?>" rel="stylesheet" />
<style>
	input, button{
		font-family:"Helvetica"!important;
	}
</style>	
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/img/opcion_body_efect_2.png');">
			<div class="wrap-login100 p-t-190 p-b-30">			
                <form id="formulario_login" action="<?= site_url("Login/Verificar")?>" method="post" class="login100-form validate-form">
                <?= $this->session->flashdata('error_usuario') ?>
					<div style="margin-bottom: 50px;">
						<img src="<?= base_url("assets/img/logo.png")?>" style="width: 400px; height: 130px;">
						<br>
					</div>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Se requiere nombre de usuario">
						<input class="input100" type="text" name="login_usuario" id="login_usuario" placeholder="Nombre de usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Se requiere contraseña">
						<input class="input100" type="password" name="login_password" id="login_password" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>
					<div class="container-login100-form-btn p-t-10" style="margin-top: 25px;">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>
