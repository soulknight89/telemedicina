/*
 Navicat Premium Data Transfer

 Source Server         : xampp - 7.4
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : telesalud

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 31/05/2020 11:38:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for usr_doctor
-- ----------------------------
DROP TABLE IF EXISTS `usr_doctor`;
CREATE TABLE `usr_doctor`  (
  `idDoctor` int(11) NOT NULL AUTO_INCREMENT,
  `colegiatura` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `horario_inicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `horario_fin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `costo_consulta` float(255, 0) NULL DEFAULT NULL COMMENT 'precio en soles',
  `tipo_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Soles o Dolares',
  `dias_atencion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idDoctor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usr_doctor_especialidad
-- ----------------------------
DROP TABLE IF EXISTS `usr_doctor_especialidad`;
CREATE TABLE `usr_doctor_especialidad`  (
  `idDoctorEspecialidad` int(11) NOT NULL AUTO_INCREMENT,
  `idEspecialidad` int(11) NOT NULL,
  `idDoctor` int(11) NOT NULL,
  `codigo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idDoctorEspecialidad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usr_especialidades
-- ----------------------------
DROP TABLE IF EXISTS `usr_especialidades`;
CREATE TABLE `usr_especialidades`  (
  `idEspecialidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idEspecialidad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_especialidades
-- ----------------------------
INSERT INTO `usr_especialidades` VALUES (1, 'Pediatria');
INSERT INTO `usr_especialidades` VALUES (2, 'Cardiologia');
INSERT INTO `usr_especialidades` VALUES (3, 'Gastroenterologia');

-- ----------------------------
-- Table structure for usr_perfiles
-- ----------------------------
DROP TABLE IF EXISTS `usr_perfiles`;
CREATE TABLE `usr_perfiles`  (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`idPerfil`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_perfiles
-- ----------------------------
INSERT INTO `usr_perfiles` VALUES (1, 'Administrador', 1);
INSERT INTO `usr_perfiles` VALUES (2, 'Doctor', 1);
INSERT INTO `usr_perfiles` VALUES (3, 'Paciente', 1);

-- ----------------------------
-- Table structure for usr_tipo_documento
-- ----------------------------
DROP TABLE IF EXISTS `usr_tipo_documento`;
CREATE TABLE `usr_tipo_documento`  (
  `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idTipoDocumento`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_tipo_documento
-- ----------------------------
INSERT INTO `usr_tipo_documento` VALUES (1, 'DNI');
INSERT INTO `usr_tipo_documento` VALUES (2, 'CE');
INSERT INTO `usr_tipo_documento` VALUES (3, 'Pasaporte');

-- ----------------------------
-- Table structure for usr_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usr_usuarios`;
CREATE TABLE `usr_usuarios`  (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_primer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_segundo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `apellido_primer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido_segundo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idPerfil` int(11) NOT NULL DEFAULT 3,
  `membresia_doctor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `membresia_paciente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `doctor` tinyint(1) NOT NULL DEFAULT 0,
  `idTipoDocumento` int(11) NOT NULL,
  `numero_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL COMMENT '1 Activo 2 Desactivado',
  PRIMARY KEY (`idUser`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_usuarios
-- ----------------------------
INSERT INTO `usr_usuarios` VALUES (1, 'administrador@telesalud.com', 'Administrador', NULL, 'Tele Salud', NULL, 1, NULL, NULL, 0, 0, '', '$2y$12$4Z13Shbg9hYNosdgK8T5ze4Pt630NOCsEE9VgZPbKv03ewrhbc2eK', '987518435', 1);

SET FOREIGN_KEY_CHECKS = 1;
