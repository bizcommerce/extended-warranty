# Estrutura do Módulo BizCommerce_ExtendedWarranty

Este documento descreve a estrutura detalhada do módulo de Garantia Estendida para Magento 2.4.x, explicando o propósito de cada diretório e arquivo principal.

## Estrutura de Diretórios

### Api/

Contém as interfaces da API que definem os contratos para o módulo.

- **Api/WarrantyRepositoryInterface.php**: Define os métodos para gerenciar garantias (CRUD).
- **Api/Data/WarrantyInterface.php**: Define a estrutura de dados para garantias.
- **Api/Data/WarrantySearchResultsInterface.php**: Define a estrutura para resultados de pesquisa de garantias.
- **Api/Data/OrderItemWarrantyInterface.php**: Define a estrutura para informações de garantia em itens de pedido.

### Block/

Contém os blocos que são usados para renderizar conteúdo nas páginas.

#### Block/Adminhtml/

Blocos específicos para o painel administrativo.

- **Block/Adminhtml/System/Config/Info.php**: Bloco para informações na configuração do sistema.
- **Block/Adminhtml/Catalog/Product/Edit/Tab/Warranty.php**: Bloco para a aba de garantia na edição de produto.
- **Block/Adminhtml/Warranty/Edit.php**: Bloco para edição de garantia.
- **Block/Adminhtml/Warranty/Edit/Form.php**: Bloco para o formulário de edição de garantia.
- **Block/Adminhtml/Report/Warranty.php**: Bloco para o relatório de garantias.

#### Block/Cart/

Blocos relacionados ao carrinho de compras.

- **Block/Cart/Warranty.php**: Bloco para a tela de seleção de garantia após adicionar ao carrinho.

### Controller/

Contém os controladores que processam as requisições HTTP.

#### Controller/Adminhtml/

Controladores para o painel administrativo.

- **Controller/Adminhtml/Warranty/Edit.php**: Controlador para edição de garantia.
- **Controller/Adminhtml/Warranty/Save.php**: Controlador para salvar garantia.
- **Controller/Adminhtml/Warranty/Delete.php**: Controlador para excluir garantia.
- **Controller/Adminhtml/Warranty/Grid.php**: Controlador para o grid de garantias.
- **Controller/Adminhtml/Warranty/NewAction.php**: Controlador para criar nova garantia.
- **Controller/Adminhtml/Report/Index.php**: Controlador para o relatório de garantias.
- **Controller/Adminhtml/Report/ExportCsv.php**: Controlador para exportar relatório em CSV.

#### Controller/Cart/

Controladores relacionados ao carrinho de compras.

- **Controller/Cart/Warranty.php**: Controlador para a tela de seleção de garantia.
- **Controller/Cart/AddWarranty.php**: Controlador para adicionar garantia ao item do carrinho.

### Helper/

Contém classes auxiliares com funcionalidades comuns.

- **Helper/Data.php**: Classe auxiliar principal com métodos para verificar configurações e outras funcionalidades comuns.

### Model/

Contém os modelos de dados e lógica de negócios.

- **Model/Warranty.php**: Modelo principal para garantias.
- **Model/WarrantyRepository.php**: Implementação do repositório de garantias.
- **Model/WarrantySearchResults.php**: Implementação dos resultados de pesquisa de garantias.

#### Model/Api/

Implementações específicas da API.

- **Model/Api/WarrantyRepository.php**: Implementação da API para o repositório de garantias.
- **Model/Api/WarrantyInterfaceFactory.php**: Fábrica para criar instâncias de WarrantyInterface.
- **Model/Api/WarrantySearchResultsFactory.php**: Fábrica para criar instâncias de WarrantySearchResultsInterface.
- **Model/Api/WarrantyDataProvider.php**: Provedor de dados para garantias.
- **Model/Api/CollectionProcessor.php**: Processador de coleção para aplicar critérios de pesquisa.

#### Model/Config/

Classes relacionadas à configuração.

- **Model/Config/Config.php**: Classe para gerenciar configurações do módulo.
- **Model/Config/Source/CalculationType.php**: Fonte de dados para tipos de cálculo (fixo/percentual).

#### Model/Order/

Classes relacionadas a pedidos.

- **Model/Order/OrderItemWarranty.php**: Implementação de OrderItemWarrantyInterface.

#### Model/ResourceModel/

Modelos de recursos para interação com o banco de dados.

- **Model/ResourceModel/Warranty.php**: Modelo de recurso para garantias.
- **Model/ResourceModel/Warranty/Collection.php**: Coleção de garantias.
- **Model/ResourceModel/Report/Collection.php**: Coleção para o relatório de garantias.

### Observer/

Contém observadores que respondem a eventos do Magento.

- **Observer/AddToCartObserver.php**: Observador para o evento de adicionar ao carrinho.
- **Observer/SaveOrderObserver.php**: Observador para o evento de salvar pedido.

### Plugin/

Contém plugins que modificam o comportamento de classes existentes.

- **Plugin/Order/OrderGet.php**: Plugin para adicionar informações de garantia ao endpoint GET /V1/orders/{orderId}.

### Setup/

Contém scripts de instalação e atualização.

- **Setup/Patch/Data/AddExtendedWarrantyProductAttribute.php**: Patch de dados para adicionar atributo de produto.

### Test/

Contém testes unitários e de integração.

#### Test/Unit/

Testes unitários para componentes individuais.

- **Test/Unit/Helper/DataTest.php**: Testes para Helper/Data.
- **Test/Unit/Model/WarrantyTest.php**: Testes para Model/Warranty.
- **Test/Unit/Model/WarrantyRepositoryTest.php**: Testes para Model/WarrantyRepository.
- **Test/Unit/Observer/AddToCartObserverTest.php**: Testes para Observer/AddToCartObserver.

#### Test/Integration/

Testes de integração para verificar o funcionamento conjunto dos componentes.

- **Test/Integration/WarrantyIntegrationTest.php**: Testes de integração para garantias.

### view/

Contém arquivos de visualização (templates, layouts, JavaScript, CSS).

#### view/adminhtml/

Arquivos de visualização para o painel administrativo.

- **view/adminhtml/layout/**: Arquivos de layout para o painel administrativo.
- **view/adminhtml/templates/**: Templates para o painel administrativo.
- **view/adminhtml/web/**: Arquivos web (CSS, JavaScript) para o painel administrativo.

#### view/frontend/

Arquivos de visualização para a loja.

- **view/frontend/layout/**: Arquivos de layout para a loja.
- **view/frontend/templates/**: Templates para a loja.
- **view/frontend/web/**: Arquivos web (CSS, JavaScript) para a loja.

### etc/

Contém arquivos de configuração do módulo.

- **etc/module.xml**: Declaração do módulo.
- **etc/config.xml**: Configurações padrão.
- **etc/di.xml**: Configuração de injeção de dependência.
- **etc/events.xml**: Configuração de eventos.
- **etc/webapi.xml**: Configuração da API REST.
- **etc/db_schema.xml**: Esquema do banco de dados.
- **etc/extension_attributes.xml**: Configuração de atributos de extensão.

#### etc/adminhtml/

Configurações específicas para o painel administrativo.

- **etc/adminhtml/menu.xml**: Configuração do menu administrativo.
- **etc/adminhtml/routes.xml**: Configuração de rotas administrativas.
- **etc/adminhtml/system.xml**: Configuração do sistema administrativo.

#### etc/frontend/

Configurações específicas para a loja.

- **etc/frontend/events.xml**: Configuração de eventos para a loja.
- **etc/frontend/routes.xml**: Configuração de rotas para a loja.

### Arquivos na Raiz

- **registration.php**: Registra o módulo no Magento.
- **composer.json**: Configuração do Composer para o módulo.
- **README.md**: Documentação principal do módulo.

## Fluxo de Dados

1. **Configuração**: As configurações são definidas no painel administrativo e armazenadas na tabela `core_config_data`.
2. **Produto**: O atributo `extended_warranty_enabled` é adicionado aos produtos para habilitar/desabilitar a garantia estendida.
3. **Garantias**: As opções de garantia são armazenadas na tabela `bizcommerce_extended_warranty` e associadas a produtos específicos.
4. **Carrinho**: Quando um produto com garantia estendida é adicionado ao carrinho, o `AddToCartObserver` redireciona para a tela de seleção de garantia.
5. **Seleção de Garantia**: O cliente seleciona uma opção de garantia ou continua sem garantia.
6. **Pedido**: Quando o pedido é finalizado, o `SaveOrderObserver` armazena as informações de garantia nos itens do pedido.
7. **API**: A API REST permite gerenciar garantias e acessar informações de garantia em pedidos.
8. **Relatório**: O relatório de garantias vendidas coleta dados dos pedidos com garantias estendidas.

## Banco de Dados

### Tabela: bizcommerce_extended_warranty

| Coluna           | Tipo         | Descrição                                |
|------------------|--------------|------------------------------------------|
| warranty_id      | int          | ID da garantia (chave primária)          |
| product_id       | int          | ID do produto associado                  |
| warranty_name    | varchar(255) | Nome da garantia                         |
| calculation_type | varchar(50)  | Tipo de cálculo (fixed/percent)          |
| warranty_value   | decimal      | Valor da garantia                        |
| created_at       | timestamp    | Data de criação                          |
| updated_at       | timestamp    | Data de atualização                      |

## Eventos

O módulo observa os seguintes eventos:

- **checkout_cart_add_product_complete**: Quando um produto é adicionado ao carrinho.
- **sales_order_save_after**: Quando um pedido é salvo.

## Plugins

O módulo implementa os seguintes plugins:

- **bizcommerce_extendedwarranty_order_get**: Plugin para o método `get` de `Magento\Sales\Api\OrderRepositoryInterface` para adicionar informações de garantia aos itens do pedido na API.
