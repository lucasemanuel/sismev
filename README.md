<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
</p>

# Sistema Simplificado para Microempresas Varejistas (SISMEV) <a name = "sismev"></a>
> Trabalho de Conclusão de Curso, concluindo quesito obrigatório do curso de Tecnologia em Sistemas para Internet no Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte.

O Sistema Simplificado para Microempresas Varejistas (SISMEV) tem a proposta de ser sistema de informação gerencial simples, com intuito de auxiliar os gestores de microempresas, principalmente nos módulos comercial e financeiro.


## Requisitos Funcionais
ID | Nome | Descrição | Usuários
--- | --- | --- | ---
RF01 | Manter dados de Empresa | Permitir registrar, alterar, visualizar e excluir dados a respeito da empresa. | Gerente do Comércio
RF02 | Manter dados dos Colaboradores | Permitir registrar, alterar, visualizar e excluir dados a respeito dos colaboradores da empresa. | Gerente do Comércio 
RF03 | Manter dados das Categorias | Permitir registrar, alterar, visualizar e excluir dados a respeito das categorias dos produtos da empresa. | Gerente do Comércio 
RF04 | Manter dados das Variações do Produto | Permitir registrar, alterar, visualizar e excluir dados a respeito dos grupos de variação que um produto pode ter, como exemplo, marca, tamanho, cor, entre outras. | Gerente do Comércio
RF05 | Manter dados dos Produtos. | Permitir registrar, alterar, visualizar e excluir dados a respeito dos produtos da empresa. | Gerente do Comércio 
RF06 | Registrar Operações de Entrada e Saída de Produto | Permitir registrar operações de entrada e saída de um produto da empresa. As operações de entrada (incrementa) ou saída (decrementa) a quantidade de um produto. | Gerente do Comércio
RF07 | Manter dados das Despesas | Permitir registrar, alterar, visualizar e excluir dados a respeito das despesas da empresa. | Gerente do Comércio
RF08 | Manter dados dos Métodos de Pagamentos | Permitir registrar, alterar, visualizar e excluir dados a respeito dos métodos de pagamentos da empresa. | Gerente do Comércio
RF09 | Ativar ou desativar Métodos de Pagamentos | Permitir ativar ou desativar os métodos de pagamentos da empresa, mantidos no requisito RF08. | Gerente do Comércio
RF10 | Listar Pedidos | Permitir listar todos os pedidos da empresa. | Gerente do Comércio e Operador de Caixa 
RF11 | Excluir Pedidos em aberto | Permitir que qualquer pedido em aberto possa ser excluído. | Gerente do Comércio 
RF12 | Gerenciar itens do Pedido | Permitir adicionar ou remover produtos no pedido. | Gerente do Comércio e Operador de Caixa 
RF13 | Registrar venda | Permitir registrar efetivação da venda, possibilitando o pagamento em diversas formas e registrando a saídas dos produtos vendidos (RF07). | Gerente do Comércio e Operador de Caixa 
RF14 | Cancelar venda | Permitir cancelar venda em operação. | Gerente do Comércio e Operador de Caixa 
RF15 | Desfazer venda | Permite que a venda seja desfeita e reverte as operações de saídas dos produtos do pedido. | Gerente do Comércio 
RF16 | Extrair relatórios de Vendas | Permite filtrar dados e extrair relatórios de vendas da empresa. | Gerente do Comércio 
RF17 | Extrair relatórios das Despesas | Permite filtrar dados e extrair relatórios das despesas da empresa. | Gerente do Comércio 
RF18 | Ativar ou desativar Colaboradores | Permitir ativar ou desativar os colaboradores da empresa, mantidos no requisito RF02. | Gerente do Comércio
RF19 | Ativar ou desativar Produtos | Permitir ativar ou desativar os produtos da empresa, mantidos no requisito RF05. | Gerente do Comércio 
RF20 | Desfazer Operações de Entrada e Saída | Permitir que as operações possam ser desfeitas, revertendo o efeito daquela operação no sistema. | Gerente do Comércio 
RF21 | Extrair Relatórios de Entrada e Saídas dos Produtos | Permite filtrar dados e extrair relatórios a respeito da entrada e saída dos produtos. | Gerente do Comércio 
RF22 | Deixar Venda em aberto | Permite deixar a venda em standby. | Gerente do Comércio e Operador de Caixa | RF23 | Visualizar comprovante da venda | Permitir visualizar o comprovante da venda. | Gerente do Comércio e Operador de Caixa


### Pré-requisitos <a name = "requirements"></a>

Instalar extensões do PHP, para verificar quais são as extensões utilize o comando após clonar o projeto
```
php -S localhost:8888 requirements.php
```

Instalar o [Intl](https://www.php.net/manual/pt_BR/book.intl.php)
```
apt install php-intl
```

## Como instalar <a name = "install"></a>

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

## Screenshots
<p align="center" >
    <img src="https://user-images.githubusercontent.com/31216249/106396101-acef7680-63e4-11eb-831b-827587979e0f.png" alt="screenshot 1" />
    <img src="https://user-images.githubusercontent.com/31216249/106396020-3488b580-63e4-11eb-860d-bdf40a018182.png" alt="screenshot 2" />
    <img src="https://user-images.githubusercontent.com/31216249/106396028-45392b80-63e4-11eb-868d-3582060364e2.png" alt="screenshot 3" />
    <img src="https://user-images.githubusercontent.com/31216249/106396033-4e29fd00-63e4-11eb-90f4-fdf8105b92f2.png" alt="screenshot 4" />
    <img src="https://user-images.githubusercontent.com/31216249/106396110-b973cf00-63e4-11eb-9f64-238de28da166.png" alt="screenshot 4" />
</p>
