<div class="modal fade" id="modal-addProf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100">Adicione sua profissão!</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="login" class="form-login d-flex flex-column" autocomplete="off" onsubmit="sendLogin(event)">
        <div class="modal-body mx-0">
            
              <!-- ESPECIALIZAÇÃO -->
              <div class="form-group mb-3">
                <label for="especializacao" class="form-label">Profissão</label>
                <select name="profissao" id="addProf">
                  <option value="" selected>Selecione uma profissão</option>
                  <?php 
                    $profissoes = $profissaoClass->selectAll();

                    foreach ($profissoes as $prof):

                      [$idprof, $dscprof] = [$prof['idprof'], ucfirst($prof['dscprof'])];

                      echo <<<ITEM
                        <option value="{$idprof}">{$dscprof}</option>
                      ITEM;
                      
                    endforeach;
                  ?>
                </select>
              </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario"></div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-green"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SELECT SEARCHABLE -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.1/dist/js/tom-select.complete.min.js"></script>
<script src="js/adicionarProf.js"></script>