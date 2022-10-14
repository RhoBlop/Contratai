-- Usuários sem profissão cadastrada
SELECT nomuser as "Usuário", descrEmailuser as "Email", datNascimentouser as "Nascimento", numCPFuser as "CPF", descrBairro as "Bairro", descrCidade as "Cidade", descrEstado as "Estado"
FROM usuario AS usr 
LEFT JOIN userEspec as useres ON (useres.iduser = usr.iduser)
INNER JOIN bairro as bair ON (usr.idBairro = bair.idBairro) 
INNER JOIN cidade as cid ON (bair.idCidade = cid.idCidade)
INNER JOIN estado as es ON (cid.idEstado = es.idEstado)
WHERE useres.idEspec is NULL

-- Usuários com profissão cadastrada
SELECT DISTINCT nomuser as "Usuário", descrEmailuser as "Email", datNascimentouser as "Nascimento", numCPFuser as "CPF", descrBairro as "Bairro", descrCidade as "Cidade",
descrEstado as "Estado", descrProf as "Profissão", descrEspec as "Especialização"
FROM usuario AS usr 
INNER JOIN userEspec as useres ON (useres.iduser = usr.iduser)
INNER JOIN especializacao as espec ON (useres.idEspec = espec.idEspec)
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)
INNER JOIN bairro as bair ON (usr.idBairro = bair.idBairro) 
INNER JOIN cidade as cid ON (bair.idCidade = cid.idCidade)
INNER JOIN estado as es ON (cid.idEstado = es.idEstado)

-- Especializações e suas respectivas profissões
SELECT descrEspec as "Especialização", descrProf as "Profissão"
FROM especializacao as espec
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)

-- Dias da semana disponíveis de um usuário
SELECT DISTINCT descrDiaSemn as "DiaSemana", nomuser as "Usuário", descrEmailuser as "Email"
FROM usuario AS usr
INNER JOIN userDisp as userdi ON (usr.iduser = userdi.iduser)
INNER JOIN disponibilidade as disp ON (userdi.idDisp = disp.idDisp)
INNER JOIN diaSemana as diaSemn ON (disp.idDiaSemn = diaSemn.idDiaSemn)
/* WHERE usr.iduser = (X) */

-- PROFISSÕES MAIS CADASTRADAS + MÉDIA DE AVALIAÇÃO
SELECT top.idprof, top.descrprof, top.numuser, avg(aval.notaavaliacao) AS mediaavaliacao 
FROM (SELECT count(*) AS numuser, prof.idprof, prof.descrProf
    FROM profissao AS prof
    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
    INNER JOIN userEspec AS useres ON (espec.idespec = useres.idespec)
    INNER JOIN usuario AS usr ON (useres.iduser = usr.iduser)
    GROUP BY prof.idprof, prof.descrProf
    ORDER BY count(*) DESC
    LIMIT :limit) AS top

    INNER JOIN profissao AS prof ON (top.idprof = prof.idprof)
    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
GROUP BY top.descrprof, top.numuser, top.idprof
ORDER BY top.numuser DESC;

-- Média de avaliação por profissão - em construção
SELECT *
FROM usuario AS usr
INNER JOIN avaliacao as avl ON (usr.iduser = avl.idAvaliado)
INNER JOIN userEspec as useres ON (usr.iduser = useres.iduser)
INNER JOIN especializacao as espec ON (useres.idEspec = espec.idEspec)
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)