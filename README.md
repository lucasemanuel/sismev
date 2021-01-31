<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">SISMEV</h1>
    <br>
</p>

## install

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

Criar regras de acesso
```
php yii rbac/init
```

Subir servidor
```
php yii serve
```
