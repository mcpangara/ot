
<style type="text/css">
    #myform{
        border-radius: 10px; margin: 0 auto; border: 1px solid #AAA; background: #FFF; padding: 1ex;
    }
    #myform input, #myform label{
        height: 2em;
        color: #000;
    }
    #myform input{
        width: auto;
        border:1px solid #999;
        padding: 2px;
        display: inline;
    }
</style>
<section id="tabs"  class="contenidos" ng-controller="test">
    <br>
    <div class="tabs_aplier row">
        <div class="row col m2"></div>
        <div id="myform" class="row col m8">
        	<div class="col m8">
        		<form action="<?= base_url('')?>" method="POST">
        				<h5>Sistema de información para ordenes de trabajo</h5>
                        <h6>Inicio de sesion:</h6>
                        <hr>

        				<div class="row">
        					<label class="col m4">Usuario:</label>
        					<input class="col m4" type="text" name="user" placeholder="Ej: 3784453">
        				</div>
        				<div class="row">
        					<label class="col m4">Contraseña:</label>
        					<input class="col m4" type="password" name="pass" placeholder="tu contraseña">
        				</div>

                        <button type="submit" class="btn green">Validar</button>
        		</form>
        	</div>

        	<div class="col m4">
                <br><br>
        		<img src="<?= base_url("assets/img/termotecnica.png") ?>" alt="" style="width: 200px;" />
        	</div>
        </div>
    </div>
</section>

