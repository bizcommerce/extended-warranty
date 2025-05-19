# Módulo de Garantia Estendida para Magento 2.4.x

## Visão Geral

O módulo BizCommerce_ExtendedWarranty adiciona funcionalidade de garantia estendida para produtos em lojas Magento 2.4.x. Ele permite que os administradores configurem opções de garantia estendida para produtos específicos e oferece aos clientes a possibilidade de adicionar essas garantias aos seus produtos durante o processo de compra.

## Características

- Configuração global para habilitar/desabilitar o módulo
- Configuração de garantia estendida por produto
- Suporte para cálculo de valor fixo ou percentual
- Tela intermediária após adicionar produto ao carrinho para seleção de garantia
- Armazenamento das informações de garantia no pedido
- Relatório administrativo de garantias vendidas
- API REST completa para integração com sistemas externos
- Testes unitários e de integração

## Requisitos

- Magento 2.4.x
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

## Instalação

### Método 1: Usando Composer (Recomendado)

1. Abra um terminal e navegue até o diretório raiz do Magento
2. Execute os seguintes comandos:

```bash
composer require bizcommerce/module-extended-warranty
bin/magento module:enable BizCommerce_ExtendedWarranty
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:clean
bin/magento cache:flush
```

### Método 2: Instalação Manual

1. Baixe o arquivo ZIP do módulo
2. Extraia o conteúdo para o diretório `app/code/BizCommerce/ExtendedWarranty` da sua instalação Magento
3. Execute os seguintes comandos:

```bash
bin/magento module:enable BizCommerce_ExtendedWarranty
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:clean
bin/magento cache:flush
```

## Configuração

### Configuração Global

1. Acesse o painel administrativo do Magento
2. Navegue para **Lojas > Configuração > BizCommerce > Garantia Estendida**
3. Configure as seguintes opções:
   - **Habilitar Módulo**: Ativa ou desativa o módulo globalmente
   - **Tipo de Cálculo Padrão**: Define o tipo de cálculo padrão para novas garantias (Fixo ou Percentual)

### Configuração por Produto

1. Acesse o painel administrativo do Magento
2. Navegue para **Catálogo > Produtos**
3. Edite um produto
4. Na aba **Garantia Estendida**, configure:
   - **Habilitar Garantia Estendida**: Ativa ou desativa a garantia estendida para este produto
   - Adicione opções de garantia usando o botão **Adicionar Garantia**
   - Para cada opção, defina:
     - **Nome da Garantia**: Nome descritivo da garantia
     - **Tipo de Cálculo**: Fixo ou Percentual
     - **Valor da Garantia**: Valor fixo ou percentual a ser aplicado

## Uso

### Para Administradores

#### Gerenciamento de Garantias

1. Acesse o painel administrativo do Magento
2. Navegue para **Catálogo > Produtos**
3. Edite um produto
4. Na aba **Garantia Estendida**, gerencie as opções de garantia

#### Relatório de Garantias

1. Acesse o painel administrativo do Magento
2. Navegue para **Relatórios > Garantia Estendida > Relatório de Garantias**
3. Visualize as garantias vendidas, filtre por período, produto ou cliente
4. Exporte o relatório em formato CSV se necessário

### Para Clientes

1. Adicione um produto ao carrinho
2. Se o produto tiver garantia estendida habilitada, uma tela intermediária será exibida
3. Selecione uma opção de garantia ou continue sem garantia
4. Prossiga com o checkout normalmente

## API REST

O módulo fornece uma API REST completa para integração com sistemas externos. Consulte a documentação detalhada em:

- [Exemplos de Uso da API](docs/api_examples.md)
- [Coleção Postman](docs/postman_collection.json)

### Endpoints Principais

- `GET /V1/extended-warranty/product/{productId}/warranty` - Lista garantias de um produto
- `GET /V1/extended-warranty/warranty/{warrantyId}` - Obtém detalhes de uma garantia
- `POST /V1/extended-warranty/product/{productId}/warranty` - Cria nova garantia
- `PUT /V1/extended-warranty/product/{productId}/warranty/{warrantyId}` - Atualiza garantia existente
- `DELETE /V1/extended-warranty/product/{productId}/warranty/{warrantyId}` - Remove garantia

## Estrutura do Módulo

```
BizCommerce/ExtendedWarranty/
├── Api/                           # Interfaces da API
│   └── Data/                      # Interfaces de dados
├── Block/                         # Blocos para renderização
│   ├── Adminhtml/                 # Blocos do painel administrativo
│   └── Cart/                      # Blocos do carrinho
├── Controller/                    # Controladores
│   ├── Adminhtml/                 # Controladores do painel administrativo
│   └── Cart/                      # Controladores do carrinho
├── Helper/                        # Classes auxiliares
├── Model/                         # Modelos de dados
│   ├── Api/                       # Implementações da API
│   ├── Config/                    # Configurações
│   ├── Order/                     # Modelos relacionados a pedidos
│   └── ResourceModel/             # Modelos de recursos
├── Observer/                      # Observadores de eventos
├── Plugin/                        # Plugins para modificar comportamentos
├── Setup/                         # Scripts de instalação
├── Test/                          # Testes
│   ├── Unit/                      # Testes unitários
│   └── Integration/               # Testes de integração
├── view/                          # Arquivos de visualização
│   ├── adminhtml/                 # Visualizações do painel administrativo
│   └── frontend/                  # Visualizações da loja
├── composer.json                  # Configuração do Composer
├── etc/                           # Configurações do módulo
│   ├── adminhtml/                 # Configurações do painel administrativo
│   └── frontend/                  # Configurações da loja
└── registration.php               # Registro do módulo
```

## Suporte

Para suporte, entre em contato com:

- Email: suporte@bizcommerce.com.br
- Website: https://www.bizcommerce.com.br

## Licença

Este módulo é distribuído sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
