# Contratai
 *Repositório do código fonte do projeto Contratai, que visa a construção de um website que facilite a contratação de serviços autônomos.*
 
## 🤔 Como instalar nosso repositório? 

É simples! Seguindo os passos a seguir, você poderá conferir nosso website funcionando (localmente, em sua máquina). 

### 📥 Instalando

Primeiro, você deve baixar nosso repositório clicando em **<> Code** -> **Download ZIP**. Extraia esses arquivos. <br>

Agora, você precisa de um webserver para rodar o apache localmente em seu computador. Recomendamos que você utilize o **Xampp**, mas você pode utilizar qualquer outro programa, como o USBwebserver. Após instalado, no caso do xampp, abra o arquivo **httpd.conf**, localizado em **Apache/conf**. Mude as seguintes linhas. <br>

    ...
    #
    # DocumentRoot: The directory out of which you will serve your
    # documents. By default, all requests are taken from this directory, but
    # symbolic links and aliases may be used to point to other locations.
    #
    DocumentRoot "C:\Users\20201TIIMI0179\Documents\GitHub\Contratai" -> Caminho do Contrata Ai
    <Directory "C:\Users\20201TIIMI0179\Documents\GitHub\Contratai"> -> Caminho do Contrata Ai. 
    ...
É também necessário editar o arquivo **php.ini**, localizado dentro da pasta **php** do sotfware utilizado. Dentro dele, descomente (retire o **;**) as seguintes linhas:

    extension=intl
    .
    .
    .
    extension=pdo_pgsql
    extension=pgsql

Feito tudo isso, reinicie seu Xampp, aperte "Start", abra seu navegador e digite "_localhost_". <br>

![Print do Xampp](https://github.com/RhoBlop/Contratai/blob/develop/images/readme/printXampp.png) <br>
_Aperte Start_<br><br>

![Print do Navegador](https://github.com/RhoBlop/Contratai/blob/develop/images/readme/printNavegador.png) <br>
_Abra o localhost_<br><br>

## 😁 Tudo pronto

Agora é só você criar sua conta, logar e **contratar**!
