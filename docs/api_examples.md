# Exemplos de Uso da API REST - BizCommerce_ExtendedWarranty

Este documento contém exemplos de uso da API REST do módulo de Garantia Estendida para Magento 2.4.x.

## Autenticação

Todas as requisições para a API REST do Magento requerem autenticação. Você pode usar token de acesso ou credenciais OAuth. Nos exemplos abaixo, usaremos o método de token de acesso.

Para obter um token de acesso, faça uma requisição POST para o endpoint `/V1/integration/admin/token` com suas credenciais:

```
POST /rest/V1/integration/admin/token
Content-Type: application/json

{
  "username": "admin",
  "password": "admin123"
}
```

A resposta será um token que deve ser incluído no cabeçalho `Authorization` de todas as requisições subsequentes:

```
Authorization: Bearer <token>
```

## Endpoints Disponíveis

### 1. Listar Garantias de um Produto

**Endpoint:** `GET /rest/V1/extended-warranty/product/{productId}/warranty`

**Descrição:** Retorna todas as opções de garantia estendida disponíveis para um produto específico.

**Exemplo de Requisição:**
```
GET /rest/V1/extended-warranty/product/1/warranty
Authorization: Bearer <token>
```

**Exemplo de Resposta:**
```json
{
  "items": [
    {
      "warranty_id": 1,
      "product_id": 1,
      "warranty_name": "Garantia Básica - 1 ano",
      "calculation_type": "fixed",
      "warranty_value": 99.90
    },
    {
      "warranty_id": 2,
      "product_id": 1,
      "warranty_name": "Garantia Premium - 2 anos",
      "calculation_type": "fixed",
      "warranty_value": 199.90
    },
    {
      "warranty_id": 3,
      "product_id": 1,
      "warranty_name": "Garantia Estendida - 10%",
      "calculation_type": "percent",
      "warranty_value": 10.00
    }
  ],
  "search_criteria": {
    "filter_groups": [
      {
        "filters": [
          {
            "field": "product_id",
            "value": "1",
            "condition_type": "eq"
          }
        ]
      }
    ]
  },
  "total_count": 3
}
```

### 2. Obter Detalhes de uma Garantia Específica

**Endpoint:** `GET /rest/V1/extended-warranty/warranty/{warrantyId}`

**Descrição:** Retorna os detalhes de uma garantia estendida específica.

**Exemplo de Requisição:**
```
GET /rest/V1/extended-warranty/warranty/1
Authorization: Bearer <token>
```

**Exemplo de Resposta:**
```json
{
  "warranty_id": 1,
  "product_id": 1,
  "warranty_name": "Garantia Básica - 1 ano",
  "calculation_type": "fixed",
  "warranty_value": 99.90
}
```

### 3. Criar Nova Garantia

**Endpoint:** `POST /rest/V1/extended-warranty/product/{productId}/warranty`

**Descrição:** Cria uma nova opção de garantia estendida para um produto específico.

**Exemplo de Requisição:**
```
POST /rest/V1/extended-warranty/product/1/warranty
Authorization: Bearer <token>
Content-Type: application/json

{
  "warranty": {
    "product_id": 1,
    "warranty_name": "Garantia Super Premium - 3 anos",
    "calculation_type": "fixed",
    "warranty_value": 299.90
  }
}
```

**Exemplo de Resposta:**
```json
{
  "warranty_id": 4,
  "product_id": 1,
  "warranty_name": "Garantia Super Premium - 3 anos",
  "calculation_type": "fixed",
  "warranty_value": 299.90
}
```

### 4. Atualizar Garantia Existente

**Endpoint:** `PUT /rest/V1/extended-warranty/product/{productId}/warranty/{warrantyId}`

**Descrição:** Atualiza uma opção de garantia estendida existente.

**Exemplo de Requisição:**
```
PUT /rest/V1/extended-warranty/product/1/warranty/4
Authorization: Bearer <token>
Content-Type: application/json

{
  "warranty": {
    "warranty_id": 4,
    "product_id": 1,
    "warranty_name": "Garantia Super Premium - 3 anos",
    "calculation_type": "fixed",
    "warranty_value": 349.90
  }
}
```

**Exemplo de Resposta:**
```json
{
  "warranty_id": 4,
  "product_id": 1,
  "warranty_name": "Garantia Super Premium - 3 anos",
  "calculation_type": "fixed",
  "warranty_value": 349.90
}
```

### 5. Excluir Garantia

**Endpoint:** `DELETE /rest/V1/extended-warranty/product/{productId}/warranty/{warrantyId}`

**Descrição:** Remove uma opção de garantia estendida.

**Exemplo de Requisição:**
```
DELETE /rest/V1/extended-warranty/product/1/warranty/4
Authorization: Bearer <token>
```

**Exemplo de Resposta:**
```json
true
```

### 6. Verificar Garantias em um Pedido

**Endpoint:** `GET /rest/V1/orders/{orderId}`

**Descrição:** Retorna os detalhes de um pedido, incluindo as informações de garantia estendida para os itens que possuem garantia.

**Exemplo de Requisição:**
```
GET /rest/V1/orders/1
Authorization: Bearer <token>
```

**Exemplo de Resposta (trecho relevante):**
```json
{
  "items": [
    {
      "item_id": 1,
      "sku": "24-MB01",
      "name": "Joust Duffle Bag",
      "price": 34,
      "qty_ordered": 1,
      "extension_attributes": {
        "extended_warranty": {
          "warranty_name": "Garantia Básica - 1 ano",
          "warranty_value": 99.90,
          "warranty_time": "Garantia Básica - 1 ano"
        }
      }
    }
  ]
}
```

## Exemplos de Código

### PHP

```php
<?php
// Exemplo de como listar garantias de um produto usando PHP

$token = 'seu_token_aqui';
$productId = 1;
$url = 'https://seu-magento.com/rest/V1/extended-warranty/product/' . $productId . '/warranty';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

$warranties = json_decode($response, true);
print_r($warranties);
```

### JavaScript

```javascript
// Exemplo de como criar uma nova garantia usando JavaScript/Fetch API

const token = 'seu_token_aqui';
const productId = 1;
const url = `https://seu-magento.com/rest/V1/extended-warranty/product/${productId}/warranty`;

const warrantyData = {
  warranty: {
    product_id: productId,
    warranty_name: "Garantia JavaScript - 1 ano",
    calculation_type: "fixed",
    warranty_value: 129.90
  }
};

fetch(url, {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(warrantyData)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Erro:', error));
```

## Códigos de Status HTTP

- **200 OK**: A requisição foi bem-sucedida
- **201 Created**: Um novo recurso foi criado com sucesso
- **400 Bad Request**: A requisição contém parâmetros inválidos
- **401 Unauthorized**: Autenticação necessária ou falhou
- **404 Not Found**: O recurso solicitado não foi encontrado
- **500 Internal Server Error**: Erro interno do servidor
