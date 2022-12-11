<?php
    /**
     * Devolve a string HTML de um card de contrato
     * 
     * @param int $idUser
     * @param string $imgPerfil
     * @param string $headerMsg
     * @param string $especializacao
     * @param array $diasContrato
     * @param string $descrContrato
     * @param array $botoes
     * @param string $aviso
     * @param string $dataCriacao
     * @param string $idContrato
     * 
     * @return string
     */
    function constructContratoCard($idUser, $imgPerfil = null, $headerMsg = "", $especializacao = "", $diasContrato = [], $descrContrato = "", $botoes = [], $aviso = "", $dataCriacao = "", $idContrato = "") {
        $timeElapsed = timeElapsedString($dataCriacao);
        $imgSrc = $imgPerfil ?? "../images/temp/default-pic.png";

        $descricao = $descrContrato !== "" ? "Descrição: <i class='text-muted'>'{$descrContrato}'</i>" : "";

        $diasString = "";
        foreach ($diasContrato as $dia) {
            if (isDateExpired($dia)) {
                $class = " expired";
            } else {
                $class = "";
            }
            $dataFormatada = getMediumDate($dia);
            $diasString .= <<<HTML
                <div class='date-chip{$class}'>
                    {$dataFormatada}
                </div>
            HTML;
        }

        $botoesString = "";
        if (!empty($botoes)) {
            if (isset($botoes[0])) {
                $btn = $botoes[0];
                if (isset($btn[2])) {
                    $botoesString .= <<<HTML
                        <div class="btn btn-green" onclick="{$btn[1]}" data-bs-toggle="{$btn[2]}" data-bs-target="#avaliacao{$idContrato}">
                            {$btn[0]}
                        </div>
                    HTML;
                }
                else {
                    $botoesString .= <<<HTML
                        <div class="btn btn-green" onclick="{$btn[1]}">
                            {$btn[0]}
                        </div>
                    HTML;
                }
            }

            if (isset($botoes[1])) {
                $btn = $botoes[1];
                $botoesString .= <<<HTML
                    <div class="btn btn-outline-dark" onclick="{$btn[1]}">
                        {$btn[0]}
                    </div>
                HTML;
            }
        }
    

        return <<<HTML
            <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                <div class="d-flex gap-3">
                    <div class="clickable-image">
                        <img src="{$imgSrc}">
                        <a class="stretched-link" href="perfil-publico.php?id={$idUser}">
                            
                        </a>
                    </div>
                    <div class="text">
                        <h8>{$headerMsg}</h8>

                        <p class="text-muted">Profissão: {$especializacao}</p>
                        <!-- <p class="text-muted">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, sint."</p> -->
                        <p>Dias agendados:</p>
                        <div class="contract-dates my-2">
                            ${diasString}
                        </div>
                        <p>{$descricao}</p>
                        <p class="my-1 "><b>{$aviso}</b></p>
                        <div class="contrato-buttons my-2 d-flex gap-2">
                            {$botoesString}
                        </div>
                    </div>
                </div>
                <div class="time text-end">
                    <p class="text-muted">{$timeElapsed}</p>
                </div>
            </div>
        HTML;
    }

    function constructNullCard() {
        echo <<<HTML
                <div class="empty-accordion accordion-body"><span class="text-muted">Nada por aqui.</span></div>
            HTML;
    }
?>