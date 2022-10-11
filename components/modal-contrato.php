<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<div class="modal fade" id="modal-contrato" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center shadow-sm">
          <h2 class="modal-title">Contratar</h2>
        </div>
  
        <form id="login" class="form-login d-flex flex-column text-center">
          <div class="modal-body mx-0">
                <!-- EMAIL -->
                <div class="form-group mb-3">
                    <label for="select-espec" class="form-label">Especialização</label>
                    <select class="form-control form-select" id="select-espec" aria-label="select">
                        <option value="" selected disabled>Selecione a especialização</option>
                        <option value="1">Professor de matemática</option>
                        <option value="2">Professor de física</option>
                        <option value="3">Designer Gráfico</option>
                    </select>
                </div>
    
                <!-- SENHA -->
                <div class="form group mb-3">
                    <label for="password" class="form-label">Período</label>
                    <input type="text" class="form-control" name="datefilter" required>
                </div>
  
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-green">Solicitar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Concluir',
                cancelLabel: 'Limpar',
                monthNames: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
                ],

                daysOfWeek: [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
                ],
            },
            buttonClasses: "btn",
            applyButtonClasses: "btn-outline-green",
            opens: 'center',
            cancelClass: 'btn-link',
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>
