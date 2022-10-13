<div class="modal fade" id="modaladdProf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100">Adicione sua profissão!</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

        <div id="modalBody" class="modal-body mx-0">
            <div class="form-group mb-3 text-muted text-center">
                Caso não encontre sua profissão/especialização, é possível digitar uma nova categoria e adicioná-la, sendo mais tarde analisada por nossos especialistas (evite realizar tal ação). 
            </div>
            
            <!-- ESPECIALIZAÇÃO -->
            <div class="form-group mb-3">
                <label for="especializacao" class="form-label">Profissão</label>
                <select name="profissao" id="addProf">
                    <option value="" selected>Selecione uma profissão</option>
                    <?php 
                    $profissaoClass = new Profissao();
                    $profissoes = $profissaoClass->selectAll()["dados"];

                    foreach ($profissoes as $prof):

                        [$idprof, $descrprof] = [$prof['idprof'], ucfirst($prof['descrprof'])];

                        echo <<<ITEM
                        <option value="{$idprof}">{$descrprof}</option>
                        ITEM;
                        
                    endforeach;
                    ?>
                </select>
            </div>

            <!-- ESPECIALIZAÇÃO -->
            <div class="form-group mb-3">
                <label for="especializacao" class="form-label">Especialização</label>
                <select name="espec" id="addEspec">
                    <option value="" selected>Selecione uma profissão primeiro</option>
                </select>
            </div>
            <!-- div para comunicação com usuário -->
            <div id="feedbackUsuario"></div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button id="addEspecBtn" class="btn btn-outline-green"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
  </div>
</div>

<!-- SEARCHABLE SELECT -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.1/dist/js/tom-select.complete.min.js"></script>

<script src="js/fetch/profissoes.js"></script>