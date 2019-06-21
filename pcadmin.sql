# Host: 127.0.0.1  (Version 5.5.53)
# Date: 2019-06-06 14:44:53
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "back_examine"
#

DROP TABLE IF EXISTS `back_examine`;
CREATE TABLE `back_examine` (
  `examine_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL COMMENT '申请时间',
  `type` varchar(50) DEFAULT NULL COMMENT '申请类别',
  `money` int(11) DEFAULT NULL COMMENT '申请金额',
  `status` int(11) DEFAULT '0' COMMENT '任务状态',
  `result` int(11) DEFAULT '0' COMMENT '0默认 -2拒绝 1同意 ',
  PRIMARY KEY (`examine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='单项审核';

#
# Data for table "back_examine"
#


#
# Structure for table "back_handle"
#

DROP TABLE IF EXISTS `back_handle`;
CREATE TABLE `back_handle` (
  `handle_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `handle_name` varchar(50) DEFAULT NULL,
  `handle_events` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0 未开始 1 开始',
  `result` int(11) DEFAULT '0' COMMENT '0拒绝 1 同意',
  PRIMARY KEY (`handle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='待办处理事件';

#
# Data for table "back_handle"
#


#
# Structure for table "back_member"
#

DROP TABLE IF EXISTS `back_member`;
CREATE TABLE `back_member` (
  `cla_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cla_name` varchar(50) DEFAULT NULL,
  `cla_tel` int(11) DEFAULT NULL,
  `cla_region` varchar(50) DEFAULT NULL,
  `cla_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cla_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "back_member"
#


#
# Structure for table "back_project"
#

DROP TABLE IF EXISTS `back_project`;
CREATE TABLE `back_project` (
  `pro_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `por_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='项目点表';

#
# Data for table "back_project"
#

/*!40000 ALTER TABLE `back_project` DISABLE KEYS */;
INSERT INTO `back_project` VALUES (47,'深圳'),(48,'上海'),(52,'郑州'),(53,'北京');
/*!40000 ALTER TABLE `back_project` ENABLE KEYS */;

#
# Structure for table "back_query"
#

DROP TABLE IF EXISTS `back_query`;
CREATE TABLE `back_query` (
  `query_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fn` varchar(50) DEFAULT NULL COMMENT '项目点名称',
  `site` varchar(50) DEFAULT NULL COMMENT '项目点名称',
  `name` varchar(50) DEFAULT NULL COMMENT '员工姓名',
  `indate` varchar(100) DEFAULT NULL COMMENT '入职日期',
  `livedate` varchar(100) DEFAULT NULL COMMENT '离职日期',
  `salary` float(10,2) DEFAULT NULL COMMENT '基本工资',
  `insurance` varchar(50) DEFAULT NULL COMMENT '保险险种',
  `socialsecuritybegin` varchar(50) DEFAULT NULL COMMENT '社保起缴月份',
  `socialsecuritystop` varchar(50) DEFAULT NULL COMMENT '社保停缴月份',
  `accumulationfundcity` varchar(50) DEFAULT NULL COMMENT '公积金缴纳城市',
  `accumulationfundbegin` varchar(50) DEFAULT NULL COMMENT '公积金起缴月份',
  `accumulationfundstop` varchar(50) DEFAULT NULL COMMENT '公积金停纳缴份',
  `accumulationfundremarks` varchar(50) DEFAULT NULL COMMENT '社保公积金备注',
  `station` varchar(50) DEFAULT NULL COMMENT '岗位',
  `idnumber` varchar(50) DEFAULT NULL COMMENT '身份证号码',
  `birthday` varchar(50) DEFAULT NULL COMMENT '出生日期',
  `age` int(11) DEFAULT NULL COMMENT '年龄',
  `sex` varchar(20) DEFAULT NULL COMMENT '性别',
  `issite` varchar(50) DEFAULT NULL COMMENT '户籍地址',
  `nowsite` varchar(50) DEFAULT NULL COMMENT '现居住地址',
  `workstatus` varchar(50) DEFAULT NULL COMMENT '用工形式',
  `nowsitex` varchar(50) DEFAULT NULL COMMENT '现住地址',
  `mobile` varchar(12) DEFAULT NULL COMMENT '联系方式',
  `urgency` varchar(20) DEFAULT NULL COMMENT '紧急联系人',
  `urgencyrelation` varchar(50) DEFAULT NULL COMMENT '与紧急联系人的关系',
  `urgencymobile` varchar(15) DEFAULT NULL COMMENT '紧急联系人电话',
  `bankname` varchar(50) DEFAULT NULL COMMENT '代发银行',
  `banknumber` varchar(50) DEFAULT NULL COMMENT '银行卡号',
  `contracttype` varchar(50) DEFAULT NULL COMMENT '合同类型',
  `contractstatus` varchar(50) DEFAULT NULL COMMENT '是否签订',
  `contractbegin` varchar(50) DEFAULT NULL COMMENT '合同开始时间',
  `contractend` varchar(50) DEFAULT NULL COMMENT '合同结束时间',
  `contractremark` varchar(50) DEFAULT NULL COMMENT '合同备注',
  `idcopy` varchar(150) DEFAULT NULL COMMENT '身份证复印件',
  `bankcardcopy` varchar(150) DEFAULT NULL COMMENT '银行卡复印件',
  `staffentry` varchar(255) DEFAULT NULL COMMENT '员工入职材料清单',
  `confirmation` varchar(255) DEFAULT NULL COMMENT '乙方确认函',
  `social` varchar(255) DEFAULT NULL COMMENT '社保承诺书',
  `haining` varchar(255) DEFAULT NULL,
  `hourlyworke` varchar(50) DEFAULT NULL COMMENT '小时工声明',
  `statement` varchar(255) DEFAULT NULL COMMENT '员工需求表',
  `interview` varchar(255) DEFAULT NULL COMMENT '面试记录表',
  `job` varchar(255) DEFAULT NULL COMMENT '工作申请表',
  `employee` varchar(255) DEFAULT NULL COMMENT '员工手册B类签收单',
  `directory` varchar(255) DEFAULT NULL COMMENT '员工档案目录',
  `registration` varchar(255) DEFAULT NULL COMMENT '基层员工登记表',
  `training` varchar(255) DEFAULT NULL COMMENT '培训反馈表',
  `instructions` varchar(255) DEFAULT NULL COMMENT '员工须知',
  `agreement` varchar(255) DEFAULT NULL COMMENT '上岗协议',
  PRIMARY KEY (`query_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='人员查询';

#
# Data for table "back_query"
#


#
# Structure for table "back_record"
#

DROP TABLE IF EXISTS `back_record`;
CREATE TABLE `back_record` (
  `re_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `createt_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ips` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员日志表';

#
# Data for table "back_record"
#


#
# Structure for table "back_resume"
#

DROP TABLE IF EXISTS `back_resume`;
CREATE TABLE `back_resume` (
  `resume_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resume_data` varchar(50) DEFAULT NULL,
  `resume_dq` varchar(50) DEFAULT NULL,
  `resume_zw` varchar(255) DEFAULT NULL,
  `resume_xmd` varchar(50) DEFAULT NULL,
  `resume_name` varchar(11) DEFAULT NULL,
  `resume_xb` varchar(11) DEFAULT NULL,
  `resume_age` varchar(50) DEFAULT NULL,
  `resume_xl` varchar(255) DEFAULT NULL,
  `resume_gzjx` varchar(255) DEFAULT NULL,
  `resume_qwzw` varchar(255) DEFAULT NULL,
  `resume_qwdd` varchar(255) DEFAULT NULL,
  `resume_qwxz` int(11) DEFAULT NULL,
  `resume_tel` varchar(11) DEFAULT NULL,
  `resume_bz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='人员简历';

#
# Data for table "back_resume"
#


#
# Structure for table "back_social"
#

DROP TABLE IF EXISTS `back_social`;
CREATE TABLE `back_social` (
  `soc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `socialSecurityNumber` varchar(50) DEFAULT NULL COMMENT '社保编号',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `sex` varchar(50) DEFAULT NULL COMMENT '性别',
  `IDNumber` varchar(20) DEFAULT NULL COMMENT '身份证号码',
  `censusRegister` varchar(50) DEFAULT NULL COMMENT '户籍性质',
  `declare` varchar(50) DEFAULT NULL COMMENT '单位申报职工月平均工资性收入',
  `basics` int(11) DEFAULT NULL COMMENT '月缴费基数',
  `total` float(10,0) DEFAULT NULL COMMENT '总计',
  `site` varchar(255) DEFAULT NULL COMMENT '项目点',
  `endowmentInsurance` float(10,0) DEFAULT NULL COMMENT '养老保险（8%）',
  `medicalInsurance` float(10,0) DEFAULT NULL COMMENT '医疗保险',
  `unemploymentInsurance` float(10,0) DEFAULT NULL COMMENT '失业保险',
  `largeMedicalInsurance` float(10,0) DEFAULT NULL COMMENT '大额保险',
  `personalTotal` float(10,0) DEFAULT NULL COMMENT '个人缴纳合计',
  `cendowmentInsurance` float(10,0) DEFAULT NULL COMMENT '养老保险',
  `cmedicalInsurance` float(10,0) DEFAULT NULL COMMENT '医疗保险',
  `cunemploymentInsurance` float(10,0) DEFAULT NULL COMMENT '失业保险',
  `cemploymentInjuryInsurance` float(10,0) DEFAULT NULL COMMENT '工伤保险',
  `cmaternityInsurance` float(10,0) DEFAULT NULL COMMENT '生育保险',
  `clargeMedicalInsurance` float(10,0) DEFAULT NULL COMMENT '大额医保',
  `companyTotal` float(10,0) DEFAULT NULL COMMENT '单位缴纳合计',
  `daytime` varchar(20) DEFAULT NULL COMMENT '缴纳社保日期',
  PRIMARY KEY (`soc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='社保费用核算';

#
# Data for table "back_social"
#


#
# Structure for table "back_user"
#

DROP TABLE IF EXISTS `back_user`;
CREATE TABLE `back_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "back_user"
#


#
# Structure for table "back_wages"
#

DROP TABLE IF EXISTS `back_wages`;
CREATE TABLE `back_wages` (
  `wid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `staffid` varchar(50) DEFAULT NULL COMMENT '职员代码',
  `site` varchar(50) DEFAULT NULL COMMENT '项目点',
  `idnumber` varchar(20) DEFAULT NULL COMMENT '身份证号码',
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `date` varchar(50) DEFAULT NULL COMMENT '月份',
  `worktype` varchar(50) DEFAULT NULL COMMENT '工种',
  `signdays` int(11) DEFAULT NULL COMMENT '考勤天数',
  `salary` int(11) DEFAULT NULL COMMENT '应发工资',
  `socialsecurity` float(11,0) DEFAULT NULL COMMENT '社保扣款',
  `reservedfunds` float(11,0) DEFAULT NULL COMMENT '公积金扣款',
  `taxsalary` float(11,0) DEFAULT NULL COMMENT '计税工资',
  `deduct` float(11,0) DEFAULT NULL COMMENT '专项附加扣除',
  `personaltax` int(11) unsigned zerofill DEFAULT NULL COMMENT '个调税',
  `truesalary` int(11) DEFAULT NULL COMMENT '实发工资',
  `signature` varchar(50) DEFAULT NULL COMMENT '签名',
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='工资核算表';

#
# Data for table "back_wages"
#


#
# Structure for table "bankname"
#

DROP TABLE IF EXISTS `bankname`;
CREATE TABLE `bankname` (
  `bank_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(50) DEFAULT NULL COMMENT '代发银行名称',
  PRIMARY KEY (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='代发银行';

#
# Data for table "bankname"
#

/*!40000 ALTER TABLE `bankname` DISABLE KEYS */;
INSERT INTO `bankname` VALUES (1,'上海农商银行'),(2,'中国银行'),(3,'工商银行'),(4,'建设银行');
/*!40000 ALTER TABLE `bankname` ENABLE KEYS */;

#
# Structure for table "contract"
#

DROP TABLE IF EXISTS `contract`;
CREATE TABLE `contract` (
  `contract_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contract_name` varchar(50) DEFAULT NULL COMMENT '合同名称',
  PRIMARY KEY (`contract_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='合同';

#
# Data for table "contract"
#

/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
INSERT INTO `contract` VALUES (1,'劳动合同'),(2,'劳务协议'),(3,'非全日制合同'),(4,'实习生协议'),(5,'合作服务协议');
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;

#
# Structure for table "fund"
#

DROP TABLE IF EXISTS `fund`;
CREATE TABLE `fund` (
  `fund_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fund_name` varchar(50) DEFAULT NULL COMMENT '公积金缴纳城市',
  PRIMARY KEY (`fund_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公积金缴纳城市';

#
# Data for table "fund"
#

/*!40000 ALTER TABLE `fund` DISABLE KEYS */;
INSERT INTO `fund` VALUES (1,'上海公积金'),(2,'杭州公积金'),(3,'上海公积金');
/*!40000 ALTER TABLE `fund` ENABLE KEYS */;

#
# Structure for table "insurance"
#

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE `insurance` (
  `insurance_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(50) DEFAULT NULL COMMENT '保险险种',
  PRIMARY KEY (`insurance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='保险险种';

#
# Data for table "insurance"
#

/*!40000 ALTER TABLE `insurance` DISABLE KEYS */;
INSERT INTO `insurance` VALUES (1,'商业险'),(2,'上海社保'),(3,'海宁社保'),(4,'杭州社保'),(5,'重庆社保');
/*!40000 ALTER TABLE `insurance` ENABLE KEYS */;

#
# Structure for table "nine_admin"
#

DROP TABLE IF EXISTS `nine_admin`;
CREATE TABLE `nine_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin` varchar(50) DEFAULT NULL COMMENT '管理员账号',
  `pwd` varchar(32) DEFAULT NULL COMMENT '密码',
  `status` int(11) DEFAULT NULL,
  `quanxian` text,
  `project` varchar(50) DEFAULT NULL COMMENT '项目地点',
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

#
# Data for table "nine_admin"
#

/*!40000 ALTER TABLE `nine_admin` DISABLE KEYS */;
INSERT INTO `nine_admin` VALUES (1,'admin','202cb962ac59075b964b07152d234b70',2,'finance/submitsalary,finance/searchsalary,finance/sociasecurity,finance/checkmission,admin/waitmisson,personnel/resumes,personnel/personnel,personnel/search','52','超级管理员');
/*!40000 ALTER TABLE `nine_admin` ENABLE KEYS */;

#
# Structure for table "nine_ar"
#

DROP TABLE IF EXISTS `nine_ar`;
CREATE TABLE `nine_ar` (
  `a_id` int(11) NOT NULL COMMENT '管理员id',
  `r_id` int(11) NOT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

#
# Data for table "nine_ar"
#


#
# Structure for table "nine_power"
#

DROP TABLE IF EXISTS `nine_power`;
CREATE TABLE `nine_power` (
  `power_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `power_name` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `route` varchar(50) DEFAULT NULL COMMENT '路由',
  `is_menu` tinyint(1) DEFAULT '0' COMMENT '是否有权限：0-是 1-否',
  `pid` int(11) DEFAULT NULL COMMENT '父级id',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`power_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

#
# Data for table "nine_power"
#

/*!40000 ALTER TABLE `nine_power` DISABLE KEYS */;
INSERT INTO `nine_power` VALUES (1,'管理员管理',NULL,0,0,0),(3,'角色管理','power/administrator',0,1,0),(4,'角色功能管理','admin/management',1,1,0),(5,'财务管理','finance/submitsalary',0,0,1),(8,'工资核算提交','finance/submitsalary',1,5,1),(9,'薪资查询','finance/searchsalary',0,5,1),(11,'社保费用核算','finance/sociasecurity',1,5,1),(12,'管理员日志','admin/adminlog',0,1,0),(13,'单项任务审核','finance/checkmission',0,5,1),(18,'待处理事件','admin/waitmisson',0,5,1),(26,'控制台','console/index',0,5,1),(28,'配置规则','power/givejurisdiction',0,3,0),(33,'配置路由','admin/role',0,1,0),(34,'添加路由','admin/addadmin',0,33,0),(36,'成员管理','power/person',0,3,0),(38,'分配权限','power/add',0,3,0),(39,'添加管理员','power/addadmin',0,3,0),(41,'查看权限','power/viewjurisdiction',0,3,0),(42,'修改角色信息','power/editadmin',0,3,0),(43,'设置功能','power/givefunction',0,4,0),(44,'人事管理',NULL,0,0,1),(45,'人员简历管理','personnel/resumes',0,44,1),(46,'人员管理','personnel/personnel',0,44,1),(47,'人员查询','personnel/search',0,44,1);
/*!40000 ALTER TABLE `nine_power` ENABLE KEYS */;

#
# Structure for table "nine_role"
#

DROP TABLE IF EXISTS `nine_role`;
CREATE TABLE `nine_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `site` varchar(255) DEFAULT NULL,
  `quanxian` varchar(255) DEFAULT NULL COMMENT '权限表',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

#
# Data for table "nine_role"
#


#
# Structure for table "nine_rp"
#

DROP TABLE IF EXISTS `nine_rp`;
CREATE TABLE `nine_rp` (
  `r_id` int(11) NOT NULL COMMENT '角色id',
  `p_id` int(11) NOT NULL COMMENT '权限id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表';

#
# Data for table "nine_rp"
#


#
# Structure for table "powers"
#

DROP TABLE IF EXISTS `powers`;
CREATE TABLE `powers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `p_controller` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `p_action` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `p_id` int(11) DEFAULT NULL,
  `row` int(10) DEFAULT NULL,
  `show` int(10) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_action` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '创建Acion',
  `update_time` int(11) DEFAULT NULL COMMENT '最后更新时间',
  `last_update_by` int(11) DEFAULT NULL COMMENT '最后更新人',
  `last_update_action` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '最后更新Action',
  `last_update_ip` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '最后更新人ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "powers"
#

/*!40000 ALTER TABLE `powers` DISABLE KEYS */;
INSERT INTO `powers` VALUES (1,'管理员管理',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'角色管理',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'角色功能管理',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'管理员日志',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'人事管理',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'人员简历管理',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'人事管理',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'人员查询',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'财务管理',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'工资核算提交',NULL,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'薪资查询',NULL,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'社保费用核算',NULL,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'单项任务审核',NULL,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `powers` ENABLE KEYS */;

#
# Structure for table "product"
#

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "product"
#


#
# Structure for table "salary"
#

DROP TABLE IF EXISTS `salary`;
CREATE TABLE `salary` (
  `salary_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `salary_code` varchar(255) DEFAULT NULL,
  `salary_title` varchar(255) DEFAULT NULL,
  `salary_name` varchar(255) DEFAULT NULL,
  `create_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  `salary_gz` int(11) DEFAULT NULL,
  `salary_bx` varchar(50) DEFAULT NULL,
  `salary_qxf` int(11) DEFAULT NULL,
  `salary_txf` int(11) DEFAULT NULL,
  `salary_gjj` int(11) DEFAULT NULL,
  `salary_q_gjj` int(11) DEFAULT NULL,
  `salary_t_gjj` int(11) DEFAULT NULL,
  `salary_bz` varchar(50) DEFAULT NULL,
  `salary_gw` varchar(50) DEFAULT NULL,
  `salary_number` varchar(50) DEFAULT NULL,
  `salary_nyr` varchar(255) DEFAULT NULL,
  `salary_age` int(11) DEFAULT NULL,
  `salary_xb` varchar(255) DEFAULT NULL,
  `salary_address` varchar(255) DEFAULT NULL,
  `salary_x_address` varchar(255) DEFAULT NULL,
  `salary_fs` varchar(255) DEFAULT NULL,
  `salary_xzdz` varchar(255) DEFAULT NULL,
  `salary_lxfs` varchar(255) DEFAULT NULL,
  `salary_jjlxfx` varchar(255) DEFAULT NULL,
  `salary_jjlxrgx` varchar(255) DEFAULT NULL,
  `salary_jjtel` varchar(255) DEFAULT NULL,
  `salary_xh` varchar(255) DEFAULT NULL,
  `salary_kh` varchar(255) DEFAULT NULL,
  `salary_htlx` varchar(255) DEFAULT NULL,
  `salary_sfqd` varchar(255) DEFAULT NULL,
  `salary_ht_create_at` varchar(255) DEFAULT NULL,
  `salary_ht_update_at` datetime DEFAULT NULL,
  `salary_htbz` varchar(255) DEFAULT NULL,
  `salary_fuxinjian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "salary"
#

