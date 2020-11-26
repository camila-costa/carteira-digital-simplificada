# Carteira Digital Simplificada

Existem 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro. Usuários comuns recebem transferência e enviam dinheiro para outros usuários. Lojistas só recebem transferências, não enviam dinheiro para ninguém.

## Framework utilizado:
- [Laravel](https://laravel.com/docs/8.x/releases)

## Setup do projeto: ##

```bash
# Clone este repositório
$ git clone <https://github.com/camila-costa/carteira-digital-simplificada.git>

# Acesse a pasta do projeto no terminal/cmd
$ cd carteira-digital-simplificada

# Instale as dependências
$ composer install

# Crie uma tabela chamada simplified_wallet
# Rode as migrações do banco
$ php artisan migrate:fresh --seed

# Execute a aplicação no local
$ php artisan serve

# O servidor inciará na porta:8000 - acesse <localhost:8000/api>
```

## API RESTFul documentada em: [Carteira Digital Simplificada](https://documenter.getpostman.com/view/12417512/TVmHCyr4#intro)

## Requisitos mínimos:

* Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.
* Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
* Lojistas só recebem transferências, não enviam dinheiro para ninguém.
* Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo.
* A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.
* No recebimento de pagamento, o usuário ou lojista precisa receber notificação enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável.

## Outros requisitos:

* Caso o serviço externo não autorize a transação ou esteja indisponível, a transação deve ser revertida, porém a transação deve ficar salva com status Cancelled para fins de log.
* Deve ficar salvo a notificação da transação com o status de Sent ou Pending.
* Deve ser possível adicionar dinheiro na carteira de um usuário.
