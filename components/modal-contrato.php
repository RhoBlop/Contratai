<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
<link rel="stylesheet" href="css/flatpickr.css">

<div class="modal fade" id="modal-contrato" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center shadow-sm">
          <h2 class="modal-title">Contratar</h2>
        </div>
  
        <form id="login" class="form-login d-flex flex-column text-center" onsubmit="sendSolicitacaoContrato(event)">
            <div class="modal-body mx-0">
                <div class="form-group mb-3 text-muted text-center">
                    Preencha o tipo de serviço do contrato e em quais dias planeja-se que ele será feito. Uma solicitação será enviada ao usuário contratado e você será notificado caso ele aceite!
                </div>

                <!-- ID CONTRATADO -->
                <input type="hidden" name="contratadoId" value="<?php echo $userId?>">

                <!-- ESPECIALIZAÇÃO -->
                <div class="form-group mb-3">
                    <label for="select-espec" class="form-label">Especialização</label>
                    <select id="select-espec" class="form-control form-select" name="idEspec" aria-label="select" required>
                        <option value="" selected disabled>Selecione a especialização</option>
                        <?php 
                            foreach ($especializacoes as $espec) {
                                [$idespec, $descrespec] = [$espec["idespec"], ucfirst($espec["descrespec"])];

                                echo <<<OPTION
                                    <option value="{$idespec}">{$descrespec}</option>
                                OPTION;
                            }
                        ?>
                    </select>
                </div>
    
                <!-- DIAS DO CONTRATO -->
                <div id="dateWrapper" class="form group mb-3">
                    <label for="multidate" class="form-label">Dias do contrato</label>
                    <input id="multidate" type="text" class="form-control" name="multidate" placeholder="Selecione os dias do contrato" required data-input>
                </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario" class="collapse"></div>
  
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-green">Solicitar</button>
            </div>
        </form>
      </div>
    </div>
  </div>

<script>
    const dateInputWrapper = document.querySelector("#dateWrapper");
    let configs = {
        locale: "pt",
        mode: "multiple",
        wrap: true,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j \\d\\e M, Y",
        conjunction: " || ",
        minDate: "today",
        maxDate: new Date().fp_incr(150),
    }

    const datePicker = flatpickr(dateInputWrapper, configs);
</script>
