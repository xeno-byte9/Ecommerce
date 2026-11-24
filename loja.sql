CREATE DATABASE IF NOT EXISTS loja;
USE loja;

-- ==========================
-- USUÁRIOS
-- ==========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================
-- CATEGORIAS
-- ==========================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
);

-- ==========================
-- PIZZAS
-- ==========================
CREATE TABLE pizzas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    imagem VARCHAR(255),
    ativo TINYINT(1) DEFAULT 1,

    CONSTRAINT fk_produto_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- ==========================
-- PEDIDOS
-- ==========================
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    
    pagamento ENUM(
        'PIX',
        'BOLETO',
        'CARTAO'
    ) NOT NULL,

    status ENUM(
        'PAGO',
        'CANCELADO'
    ) DEFAULT 'PAGO',

    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- ==========================
-- ITENS DO PEDIDO
-- ==========================
CREATE TABLE pedido_itens (
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (pedido_id, produto_id),

    CONSTRAINT fk_item_pedido
        FOREIGN KEY (pedido_id)
        REFERENCES pedidos(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_item_produto
        FOREIGN KEY (produto_id)
        REFERENCES produtos(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);
