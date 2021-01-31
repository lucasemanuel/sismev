<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
</p>

# Sistema Simplificado para Microempresas Varejistas (SISMEV) <a name = "sismev"></a>

Trabalho de Conclusão de Curso, concluindo quesito obrigatório do curso de Tecnologia em Sistemas para Internet no Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte. O SISMEV é um projeto software local com suporte personalizado, com público-alvo de microempresas varejistas, sendo uma ferramenta para assistir a firma, fornecendo informações recuperadas a partir de dados introduzidos no sistema, capacitando assim o gerente em suas tomadas de decisão para manutenção e crescimento da empresa.

## Screenshots
<p align="center" >
    <img src="https://user-images.githubusercontent.com/31216249/106396101-acef7680-63e4-11eb-831b-827587979e0f.png" alt="screenshot 1" height="80%" width="80%"/>
    <img src="https://user-images.githubusercontent.com/31216249/106396020-3488b580-63e4-11eb-860d-bdf40a018182.png" alt="screenshot 2" height="80%" width="80%"/>
    <img src="https://user-images.githubusercontent.com/31216249/106396028-45392b80-63e4-11eb-868d-3582060364e2.png" alt="screenshot 3" height="80%" width="80%"/>
    <img src="https://user-images.githubusercontent.com/31216249/106396033-4e29fd00-63e4-11eb-90f4-fdf8105b92f2.png" alt="screenshot 4" height="80%" width="80%"/>
    <img src="https://user-images.githubusercontent.com/31216249/106396110-b973cf00-63e4-11eb-9f64-238de28da166.png" alt="screenshot 4" height="80%" width="80%"/>
</p>

## Features <a name = "features"></a>
- Módulo de PDV;
- Módulo de Despesas;
- Controle de Estoque;
- Multiusuário
- Papeis com limitação para uso de funcionalidades;
- Criação de relatórios personalizados;
- Gerencia de produtos com variação;
- Categorização de produto;

## Built Using <a name = "built_using"></a>
- Yii
- Vue
- Axios
- Bootstrap

## Pre Requirements <a name = "requirements"></a>
Instalar extesões do PHP, verificar com comando
```
php -S localhost:8888 requirements.php
```

## install <a name = "install"></a>

Criar banco de dados e usuário (exemplo usando mysql)
``` 
CREATE DATABASE sismec;
CREATE USER 'sismec'@'localhost' IDENTIFIED BY 'sismec';
GRANT ALL PRIVILEGES ON sismec.* TO 'sismec'@'localhost';
```

Instalar dependências
```
composer install
```

Executar migrações
```
php yii migrate
```

Criar regras de acesso
```
php yii rbac/init
```

Subir servidor
```
php yii serve
```
