<div id="modal_exito" class="modal fade" aria-hidden="false" data-backdrop="static" data-keyboard="false" style="z-index:999999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div><center><img src='<?= base_url("assets/img/success.png")?>' style='width:120px; height: 120px'></center></div>
        <center><label>¡La operación ha sido realizada con éxito!</label></center> 
        <center><button type="button" class="btn btn-body" data-dismiss="modal" onClick="reloadPage();">Finalizar</button></center>                
      </div>
    </div>
  </div>
</div>

<div id="modal_fail" class="modal fade" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div><center><img src='<?= base_url("assets/img/falla_general.png")?>' style='width:120px; height: 120px'></center></div>
        <center><label>¡Ooops! Algo ha salido mal, póngase en contacto con el administrador.</label></center> 
        <center><button type="button" class="btn btn-body" data-dismiss="modal">Finalizar</button></center>                
      </div>
    </div>
  </div>
</div>

<script>
  function reloadPage(){
    location.reload();
  }
</script>