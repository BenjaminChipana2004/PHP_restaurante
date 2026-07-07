-- =====================================================
-- DATOS DE EJEMPLO: RESTAURANTE (Pollo Frito, BBQ, Hamburguesas)
-- PostgreSQL - INSERT statements
-- Orden respetando dependencias de llaves for�neas
-- =====================================================

-- =====================================================
-- TABLAS MAESTRAS
-- =====================================================

INSERT INTO DB_Categoria (codCategoria, nombre) VALUES
('CAT-001', 'Pollo Frito'),
('CAT-002', 'BBQ'),
('CAT-003', 'Hamburguesas'),
('CAT-004', 'Bebidas'),
('CAT-005', 'Postres');

INSERT INTO DB_Proveedor (codProveedor, nombre, telefono, email, direccion) VALUES
('PROV-001', 'Avicola San Fernando', '999111222', 'ventas@avicolasf.com', 'Av. Industrial 123, Lima'),
('PROV-002', 'Carnes y Parrillas SAC', '999333444', 'contacto@carnesyparrillas.com', 'Jr. Las Carnes 456, Lima'),
('PROV-003', 'Distribuidora Panes del Norte', '999555666', 'info@panesdelnorte.com', 'Calle Trigo 789, Lima'),
('PROV-004', 'Bebidas y Mas EIRL', '999777888', 'pedidos@bebidasymas.com', 'Av. Refrescos 321, Lima');

INSERT INTO DB_Rol (codRol, nombre, activo) VALUES
('ROL-001', 'cocinero', TRUE),
('ROL-002', 'mesero', TRUE),
('ROL-003', 'cajero', TRUE),
('ROL-004', 'administrador', TRUE);

INSERT INTO DB_Permiso (codPermiso, nombre) VALUES
('PERM-001', 'actualizar platos'),
('PERM-002', 'registrar pedido'),
('PERM-003', 'registrar despacho'),
('PERM-004', 'realizar cobro'),
('PERM-005', 'registrar insumos'),
('PERM-006', 'agregar usuario');

INSERT INTO DB_Mesa (codMesa, numero, disponible) VALUES
('MESA-001', 1, TRUE),
('MESA-002', 2, TRUE),
('MESA-003', 3, FALSE),
('MESA-004', 4, TRUE);

-- =====================================================
-- USUARIOS
-- =====================================================

-- DB_Rol_ID: 1=cocinero, 2=mesero, 3=cajero, 4=administrador
-- DB_Rol_ID: 1=cocinero, 2=mesero, 3=cajero, 4=administrador
INSERT INTO DB_Usuario (codUsuario, nombre, email, password, activo, DB_Rol_ID) VALUES
(1001, 'Carlos Ramirez', 'carlos.ramirez@restaurante.com', '12345', TRUE, 1),
(1002, 'Maria Lopez', 'maria.lopez@restaurante.com', '12345', TRUE, 2),
(1003, 'Jorge Torres', 'jorge.torres@restaurante.com', '12345', TRUE, 3),
(1004, 'Lucia Fernandez', 'lucia.fernandez@restaurante.com', '12345', TRUE, 4),
(1005, 'Pedro Quispe', 'pedro.quispe@restaurante.com', '12345', TRUE, 1),
(1006, 'Andrea Salas', 'andrea.salas@restaurante.com', '12345', TRUE, 2);

-- DB_Permiso_ID: 1=actualizar platos, 2=generar reporte de ventas, 3=registrar pedido,
-- 4=registrar despacho, 5=efectuar cobro, 6=registrar reclamo, 7=registrar insumos, 8=actualizar usuarios
INSERT INTO DB_PermisoUsuario (DB_Permiso_ID, DB_Usuario_ID) VALUES
(1, 1), -- Carlos (cocinero): actualizar platos
(5, 1), -- Carlos (cocinero): registrar insumos
(2, 2), -- Maria (mesero): registrar pedido
(4, 3), -- Jorge (cajero): efectuar cobro
(6, 4), -- Lucia (administrador): actualizar usuarios
(3, 5), -- Pedro (cocinero): registrar despacho
(5, 5), -- Pedro (cocinero): registrar insumos
(3, 6), -- Andrea (mesero): registrar despacho
(2, 6); -- Andrea (mesero): registrar pedido

-- =====================================================
-- INVENTARIO
-- =====================================================

INSERT INTO DB_Lote (codLote, nombreProducto, DB_Proveedor_ID) VALUES
('LOTE-001', 'Pollo entero fresco', 1),
('LOTE-002', 'Costillas de cerdo', 2),
('LOTE-003', 'Pan de hamburguesa', 3),
('LOTE-004', 'Gaseosa cola 1.5L', 4);

INSERT INTO DB_Insumo (codInsumo, stock, DB_Lote_ID) VALUES
('INS-001', 150.5, 1),
('INS-002', 80.0, 2),
('INS-003', 300.0, 3),
('INS-004', 200.0, 4);

-- =====================================================
-- PLATOS
-- =====================================================

-- DB_Categoria_ID: 1=Pollo Frito, 2=BBQ, 3=Hamburguesas, 4=Bebidas, 5=Postres
INSERT INTO DB_Plato (codPlato, nombre, precio, imagenUrl, disponible, DB_Categoria_ID) VALUES
('PLATO-001', 'Combo Pollo Frito Clasico', 25.90, 'https://restaurante.com/img/pollo-frito.jpg', TRUE, 1),
('PLATO-002', 'Costillas BBQ Ahumadas', 38.50, 'https://restaurante.com/img/costillas-bbq.jpg', TRUE, 2),
('PLATO-003', 'Hamburguesa Doble Cheese', 22.00, 'https://restaurante.com/img/hamburguesa-doble.jpg', TRUE, 3),
('PLATO-004', 'Gaseosa Cola 500ml', 5.00, 'https://restaurante.com/img/gaseosa.jpg', TRUE, 4),
('PLATO-005', 'Brownie con Helado', 12.00, 'https://restaurante.com/img/brownie.jpg', TRUE, 5);

INSERT INTO DB_InsumoPlato (DB_Plato_ID, DB_Insumo_ID, codPlato, idInsumo, cantidad, esOpcional) VALUES
(1, 1, 'PLATO-001', 1, 0.5, FALSE),
(2, 2, 'PLATO-002', 2, 0.8, FALSE),
(3, 3, 'PLATO-003', 3, 1.0, FALSE),
(4, 4, 'PLATO-004', 4, 1.0, FALSE);

-- =====================================================
-- PEDIDOS
-- =====================================================

-- DB_Mesa_ID, DB_Usuario_ID
INSERT INTO DB_Pedido (codPedido, fecha, total, estado, observacion, DB_Mesa_ID, DB_Usuario_ID) VALUES
(5001, '2026-06-18', 47.90, 'entregado', 'Sin observaciones', 1, 2),
(5002, '2026-06-19', 38.50, 'en preparacion', 'Costillas bien cocidas', 2, 2),
(5003, '2026-06-20', 22.00, 'pendiente', 'Sin cebolla', 3, 2),
(5004, '2026-06-21', 17.00, 'entregado', 'Para llevar', 4, 2);

INSERT INTO DB_PlatoPedido (DB_Pedido_ID, DB_Plato_ID, codPlatoPedido, precioUnitario, estado) VALUES
(1, 1, 9001, 25.90, 'entregado'),
(1, 4, 9002, 5.00, 'enCocina'),
(2, 2, 9003, 38.50, 'enCocina'),
(3, 3, 9004, 22.00, 'pendiente');

-- =====================================================
-- FACTURACION
-- =====================================================

INSERT INTO DB_Factura (serie, numero, fecha, subtotal, igv, total, DB_Pedido_ID) VALUES
('F001', 1, '2026-06-18', 40.59, 7.31, 47.90, 1),
('F001', 2, '2026-06-19', 32.63, 5.87, 38.50, 2),
('F001', 3, '2026-06-20', 18.64, 3.36, 22.00, 3),
('F001', 4, '2026-06-21', 14.41, 2.59, 17.00, 4);