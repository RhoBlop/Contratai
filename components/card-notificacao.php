<?php
    /**
     * Devolve a string HTML de um card de notificação
     * 
     * @param int $idNotificacao
     * @param string $title
     * @param string $text
     * @param string $descrContrato
     * @param array $diasContrato
     * @param string $descrContrato
     * @param string $dataCriacao
     * 
     * @return string
     */
    function constructNotificacaoCard($idNotificacao = null, $title = "", $text = "", $descrContrato = "", $dataCriacao = "") {
        $timeElapsed = timeElapsedString($dataCriacao);

        return <<<HTML
            <div class="card card-profissao card-notificacao shadow-sm rounded-4 my-3" data-notificacaoid="{$idNotificacao}">
                <div class="card-body d-flex justify-content-between align-items-center px-4 py-3">

                    <div class="card-text pe-3">
                        <h5 class="mb-0">{$title}</h5>
                        <p class="text-muted">{$text}</p>
                        <p class="text-muted"><b>Descrição do contrato</b>: {$descrContrato}</p>
                    </div>

                    <button class="time" onclick="deleteNotificacao(event)">
                        <p>{$timeElapsed}</p>
                        <i class="fa-solid fa-trash-can"></i>
                    </button>

                </div>
            </div>
        HTML;
    }

    function constructEmptyCard() {
        echo <<<HTML
            Nenhuma notificação.
        HTML;
    }
?>