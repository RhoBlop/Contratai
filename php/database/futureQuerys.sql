-- Usuários sem profissão cadastrada
SELECT nomUsr as "Usuário", dscEmailUsr as "Email", datNascimentoUsr as "Nascimento", numCPFUsr as "CPF", dscBairro as "Bairro", dscCidade as "Cidade", dscEstado as "Estado"
FROM usuario as usr 
LEFT JOIN usrEspec as usres ON (usres.idUsr = usr.idUsr)
INNER JOIN bairro as bair ON (usr.idBairro = bair.idBairro) 
INNER JOIN cidade as cid ON (bair.idCidade = cid.idCidade)
INNER JOIN estado as es ON (cid.idEstado = es.idEstado)
WHERE usres.idEspec is NULL

-- Usuários com profissão cadastrada
SELECT DISTINCT nomUsr as "Usuário", dscEmailUsr as "Email", datNascimentoUsr as "Nascimento", numCPFUsr as "CPF", dscBairro as "Bairro", dscCidade as "Cidade",
dscEstado as "Estado", dscProf as "Profissão", dscEspec as "Especialização"
FROM usuario as usr 
INNER JOIN usrEspec as usres ON (usres.idUsr = usr.idUsr)
INNER JOIN especializacao as espec ON (usres.idEspec = espec.idEspec)
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)
INNER JOIN bairro as bair ON (usr.idBairro = bair.idBairro) 
INNER JOIN cidade as cid ON (bair.idCidade = cid.idCidade)
INNER JOIN estado as es ON (cid.idEstado = es.idEstado)

-- Especializações e suas respectivas profissões
SELECT dscEspec as "Especialização", dscProf as "Profissão"
FROM especializacao as espec
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)

-- Dias da semana disponíveis de um usuário
SELECT DISTINCT dscDiaSemn as "DiaSemana", nomUsr as "Usuário", dscEmailUsr as "Email"
FROM usuario as usr
INNER JOIN usrDisp as usrdi ON (usr.idUsr = usrdi.idUsr)
INNER JOIN disponibilidade as disp ON (usrdi.idDisp = disp.idDisp)
INNER JOIN diaSemana as diaSemn ON (disp.idDiaSemn = diaSemn.idDiaSemn)
/* WHERE usr.idUsr = (X) */

-- PROFISSÕES MAIS CADASTRADAS + MÉDIA DE AVALIAÇÃO
SELECT top.idprof, top.dscprof, top.numusr, avg(aval.notaavaliacao) AS mediaavaliacao 
FROM (SELECT count(*) AS numUsr, prof.idprof, prof.dscProf
    FROM profissao AS prof
    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
    INNER JOIN usrEspec AS usres ON (espec.idespec = usres.idespec)
    INNER JOIN usuario AS usr ON (usres.idusr = usr.idusr)
    GROUP BY prof.idprof, prof.dscProf
    ORDER BY count(*) DESC
    LIMIT :limit) AS top

    INNER JOIN profissao AS prof ON (top.idprof = prof.idprof)
    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
GROUP BY top.dscprof, top.numusr, top.idprof
ORDER BY top.numusr DESC;

-- Média de avaliação por profissão - em construção
SELECT *
FROM usuario as usr
INNER JOIN avaliacao as avl ON (usr.idUsr = avl.idAvaliado)
INNER JOIN usrEspec as usres ON (usr.idUsr = usres.idUsr)
INNER JOIN especializacao as espec ON (usres.idEspec = espec.idEspec)
INNER JOIN profissao as prof ON (espec.idProf = prof.idProf)