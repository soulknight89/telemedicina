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

 Date: 11/06/2020 22:27:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for doc_tipo_especialidad
-- ----------------------------
DROP TABLE IF EXISTS `doc_tipo_especialidad`;
CREATE TABLE `doc_tipo_especialidad`  (
  `idTipoEspecialidad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idTipoEspecialidad`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doc_tipo_especialidad
-- ----------------------------
INSERT INTO `doc_tipo_especialidad` VALUES ('RNA', 'Diplomatura');
INSERT INTO `doc_tipo_especialidad` VALUES ('RND', 'Doctorado');
INSERT INTO `doc_tipo_especialidad` VALUES ('RNE', 'Especialidad');
INSERT INTO `doc_tipo_especialidad` VALUES ('RNM', 'Maestria');
INSERT INTO `doc_tipo_especialidad` VALUES ('RNSE', 'Sub Especialidad');

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_doctor
-- ----------------------------
INSERT INTO `usr_doctor` VALUES (3, '016746', 1, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for usr_doctor_especialidad
-- ----------------------------
DROP TABLE IF EXISTS `usr_doctor_especialidad`;
CREATE TABLE `usr_doctor_especialidad`  (
  `idDoctorEspecialidad` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoEspecialidad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idDoctor` int(11) NOT NULL,
  `codigo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `certificacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idDoctorEspecialidad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_doctor_especialidad
-- ----------------------------
INSERT INTO `usr_doctor_especialidad` VALUES (2, 'RNE', 3, '007247', 'CARDIOLOGIA', '12/02/2025');

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
-- Table structure for usr_paciente
-- ----------------------------
DROP TABLE IF EXISTS `usr_paciente`;
CREATE TABLE `usr_paciente`  (
  `idPaciente` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipodoc` int(11) NOT NULL,
  `numdoc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sexo` int(11) NOT NULL,
  `fecnac` date NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rutafirma` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rutahuella` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bitactivo` tinyint(1) NOT NULL,
  `bitpermiso` int(11) NOT NULL,
  `usucrea` int(11) NOT NULL,
  `feccrea` date NOT NULL,
  `usumod` int(11) NOT NULL,
  `fecmod` date NOT NULL,
  PRIMARY KEY (`idPaciente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usr_perfiles
-- ----------------------------
DROP TABLE IF EXISTS `usr_perfiles`;
CREATE TABLE `usr_perfiles`  (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`idPerfil`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_perfiles
-- ----------------------------
INSERT INTO `usr_perfiles` VALUES (1, 'Administrador', 1);
INSERT INTO `usr_perfiles` VALUES (2, 'Paciente', 1);
INSERT INTO `usr_perfiles` VALUES (3, 'Doctor', 1);
INSERT INTO `usr_perfiles` VALUES (4, 'Registrado', 1);

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
  `idPerfil` int(11) NOT NULL DEFAULT 4,
  `membresia_doctor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `membresia_paciente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `doctor` tinyint(1) NOT NULL DEFAULT 0,
  `idTipoDocumento` int(11) NOT NULL,
  `numero_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT 1 COMMENT '1 Activo 2 Desactivado',
  PRIMARY KEY (`idUser`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usr_usuarios
-- ----------------------------
INSERT INTO `usr_usuarios` VALUES (1, 'administrador@telesalud.com', 'Administrador', NULL, 'Tele Salud', NULL, 1, NULL, NULL, 0, 0, '', '$2y$12$4Z13Shbg9hYNosdgK8T5ze4Pt630NOCsEE9VgZPbKv03ewrhbc2eK', '987518435', 1);
INSERT INTO `usr_usuarios` VALUES (3, 'prueba0@medicina.com', 'IRMA', 'GLADYS', 'ARIMA', 'FUJITA', 4, NULL, NULL, 0, 1, '1', '$2y$12$KQWPE9owG35b/Tl6ZNaPietAKLo9.FcWk6bfsSdCwsQnpMPGYBKVS', NULL, 1);
INSERT INTO `usr_usuarios` VALUES (7, 'edtorrese@outlook.com', 'Edwin', '', 'Torres', '', 4, NULL, NULL, 0, 0, '', '$2y$12$hV5Qu6BY5Cs.AcD2HRBKpuWlpy.2HWKB1SpZHv2.5wv95ar0mYFGG', NULL, 1);

SET FOREIGN_KEY_CHECKS = 1;
