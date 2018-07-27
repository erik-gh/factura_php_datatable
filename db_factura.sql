/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_factura

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-07-13 07:14:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_cliente
-- ----------------------------
DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE `tb_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id_cliente`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tb_cliente
-- ----------------------------
INSERT INTO `tb_cliente` VALUES ('1', 'Erik Tecse Huanca', '45362384', '3475004', 'etecse@gmail.com');
INSERT INTO `tb_cliente` VALUES ('2', 'Josue Chipana Valdivia', '45362389', '3475004', 'josue@gmail.com');
INSERT INTO `tb_cliente` VALUES ('3', 'Nestor Mayhua Solis', '45362385', '3344079', 'mayhua@gmail.com');

-- ----------------------------
-- Table structure for tb_detalle_factura
-- ----------------------------
DROP TABLE IF EXISTS `tb_detalle_factura`;
CREATE TABLE `tb_detalle_factura` (
  `id_dfactura` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pre_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_dfactura`) USING BTREE,
  KEY `fk_tb_detalle_venta_tb_venta` (`id_factura`) USING BTREE,
  KEY `fk_tb_detalle_venta_tb_producto` (`id_producto`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tb_detalle_factura
-- ----------------------------
INSERT INTO `tb_detalle_factura` VALUES ('1', '1', '1', '3', '12.36');
INSERT INTO `tb_detalle_factura` VALUES ('2', '1', '2', '4', '28.58');
INSERT INTO `tb_detalle_factura` VALUES ('3', '2', '3', '5', '43.25');
INSERT INTO `tb_detalle_factura` VALUES ('4', '2', '2', '3', '36.24');
INSERT INTO `tb_detalle_factura` VALUES ('5', '3', '3', '4', '12.36');
INSERT INTO `tb_detalle_factura` VALUES ('6', '3', '5', '2', '14.78');
INSERT INTO `tb_detalle_factura` VALUES ('7', '3', '7', '3', '18.89');
INSERT INTO `tb_detalle_factura` VALUES ('8', '4', '3', '5', '14.15');
INSERT INTO `tb_detalle_factura` VALUES ('9', '4', '5', '2', '14.75');
INSERT INTO `tb_detalle_factura` VALUES ('10', '4', '2', '4', '52.48');

-- ----------------------------
-- Table structure for tb_factura
-- ----------------------------
DROP TABLE IF EXISTS `tb_factura`;
CREATE TABLE `tb_factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `serie` varchar(3) DEFAULT NULL,
  `num_factura` varchar(8) DEFAULT NULL,
  `fec_fac` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_factura`) USING BTREE,
  KEY `fk_tb_factura_tb_cliente` (`id_cliente`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tb_factura
-- ----------------------------
INSERT INTO `tb_factura` VALUES ('1', '1', '001', '1', '2018-06-26 16:01:51', '150.00');
INSERT INTO `tb_factura` VALUES ('2', '2', '001', '2', '2018-06-27 12:56:14', '145.00');
INSERT INTO `tb_factura` VALUES ('3', '2', '002', '1', '2018-06-27 12:56:18', '300.00');
INSERT INTO `tb_factura` VALUES ('4', '2', '003', '1', '2018-06-26 16:02:00', '400.00');
INSERT INTO `tb_factura` VALUES ('8', '1', '001', null, '2018-06-30 00:00:00', '312.00');
INSERT INTO `tb_factura` VALUES ('7', '1', '001', null, '0000-00-00 00:00:00', '312.00');
INSERT INTO `tb_factura` VALUES ('9', '1', '001', null, '0000-00-00 00:00:00', '75.00');
INSERT INTO `tb_factura` VALUES ('10', '1', '001', null, '2018-06-30 00:00:00', '75.00');
INSERT INTO `tb_factura` VALUES ('11', '1', '001', '00000003', '0000-00-00 00:00:00', '100.00');
INSERT INTO `tb_factura` VALUES ('12', '1', '001', '00000003', '2018-06-30 00:00:00', '100.00');
INSERT INTO `tb_factura` VALUES ('13', '1', '001', '00000004', '2018-06-30 00:00:00', '238.00');
INSERT INTO `tb_factura` VALUES ('14', '1', '002', '00000002', '0000-00-00 00:00:00', '140.00');
INSERT INTO `tb_factura` VALUES ('15', '1', '002', '00000002', '2018-06-30 00:00:00', '140.00');
INSERT INTO `tb_factura` VALUES ('16', '1', '002', '00000003', '2018-07-13 00:00:00', '225.00');

-- ----------------------------
-- Table structure for tb_producto
-- ----------------------------
DROP TABLE IF EXISTS `tb_producto`;
CREATE TABLE `tb_producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tb_producto
-- ----------------------------
INSERT INTO `tb_producto` VALUES ('1', 'zapatos negros', '45');
INSERT INTO `tb_producto` VALUES ('2', 'Gorras de alpaca', '50');
INSERT INTO `tb_producto` VALUES ('3', 'Pantalones de vestir', '80');
INSERT INTO `tb_producto` VALUES ('4', 'Camizas', '80');
INSERT INTO `tb_producto` VALUES ('5', 'Polos Peru', '100');
