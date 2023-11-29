CREATE TABLE IF NOT EXISTS `user`(
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `phone` varchar(32) NOT NULL COMMENT '用户手机号',
  `yue_num` decimal(65,2) unsigned NOT NULL DEFAULT 0 COMMENT '用户余额',
  `yinbi_num` decimal(65,2) unsigned NOT NULL DEFAULT 0 COMMENT '银币数量',
  `jinbi_num` decimal(65,2) unsigned NOT NULL DEFAULT 0 COMMENT '金币数量',
  `invite_uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '上级邀请人',
  `leaflet_uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '传单邀请人',
  `experience` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '用户经验',
  `vip_expires` int unsigned NOT NULL DEFAULT 0 COMMENT 'vip过期时间',
  `create_time` date NOT NULL COMMENT '注册时间',
PRIMARY KEY (`uid`),
index index_user_phone(phone),
index index_user_experience(experience),
index index_user_vip_expires(vip_expires),
index index_create_time(create_time),
index index_invite_uid(invite_uid),
index index_leaflet_uid(leaflet_uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

CREATE TABLE IF NOT EXISTS `userinfo`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
	`uid` int(11) unsigned NOT NULL COMMENT '用户id',
	`place` json COMMENT '约会地点',
	`sex` tinyint(1) unsigned NOT NULL COMMENT '用户性别',
	`name` varchar(8) NOT NULL COMMENT '用户姓名',
	`birthday` date NOT NULL COMMENT '出生日期',
	`constellation` tinyint(1) unsigned NOT NULL COMMENT '星座',
	`weight` smallint unsigned NOT NULL COMMENT '用户体重',
	`height` smallint unsigned NOT NULL COMMENT '用户身高',
	`abdominal_muscles` tinyint(1) unsigned NOT NULL COMMENT '是否有腹肌/马甲线',
	`cup` tinyint(1) unsigned NOT NULL COMMENT '胸围',
	`education` tinyint(1) unsigned NOT NULL COMMENT '学历',
	`school` varchar(32) NOT NULL COMMENT '学校名字',
	`occupation` varchar(32) NOT NULL COMMENT '职业',
	`company_type` tinyint(1) unsigned NOT NULL COMMENT '单位类型',
	`monthly_income` tinyint(1) unsigned NOT NULL COMMENT '月收入',
	`house_and_car` tinyint(1) unsigned NOT NULL COMMENT '有无房车',
	`emotional_experience` tinyint(1) unsigned NOT NULL COMMENT '情感经历',
	`love_tendency` tinyint(1) unsigned NOT NULL COMMENT '恋爱倾向',
	`is_smoking` tinyint(1) unsigned NOT NULL COMMENT '是否抽烟',
	`is_drinking` tinyint(1) unsigned NOT NULL COMMENT '是否喝酒',
	`have_tattoo` tinyint(1) unsigned NOT NULL COMMENT '是否有纹身',
	`play_games` tinyint(1) unsigned NOT NULL COMMENT '喜欢打游戏',
  `belief` tinyint(1) unsigned NOT NULL COMMENT '宗教信仰',
  `only_child` tinyint(1) unsigned NOT NULL COMMENT '独生子女',
	`hobbies_and_specialties` varchar(1000) NOT NULL COMMENT '自我介绍与爱好与特长',
	`condition` varchar(1000) NOT NULL COMMENT '约会对象条件要求',
	`picture` json COMMENT '用户相册',
  `violation_record` varchar(100) NOT NULL DEFAULT '' COMMENT '违规记录',
  `frequency` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '展示频率',
  `is_show` tinyint(1) unsigned DEFAULT 1 NOT NULL COMMENT '资料是否显示0隐藏,1显示',
  `is_pass` tinyint(1) unsigned DEFAULT 0 NOT NULL COMMENT '是否审核通过,0审核中,1通过,2不通过,3小黑屋',
  index index_frequency(frequency),
  index index_birthday(birthday),
  index index_uid(uid),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户信息表';

CREATE TABLE IF NOT EXISTS `jinbi_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `num` decimal(65,2) NOT NULL COMMENT '金币数量',
  `type` tinyint(1) NOT NULL COMMENT '类型,1收入，2支出',
  `mark` varchar(188) NOT NULL COMMENT '记录说明，佣金-返利',
  `create_time` datetime NOT NULL COMMENT '记录时间',
PRIMARY KEY (`id`),
index index_jinbi_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='金币记录';

CREATE TABLE IF NOT EXISTS `yinbi_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `num` decimal(65,2) NOT NULL COMMENT '金币数量',
  `type` tinyint(1) NOT NULL COMMENT '类型,1收入，2支出',
  `mark` varchar(188) NOT NULL COMMENT '记录说明，佣金-返利',
  `create_time` datetime NOT NULL COMMENT '记录时间',
PRIMARY KEY (`id`),
index index_yinbi_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='银币记录';

CREATE TABLE IF NOT EXISTS `yue_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `num` decimal(65,2) NOT NULL COMMENT '余额数量',
  `type` tinyint(1) NOT NULL COMMENT '类型,1收入，2支出',
  `mark` varchar(188) NOT NULL COMMENT '记录说明，佣金-返利',
  `create_time` datetime NOT NULL COMMENT '记录时间',
PRIMARY KEY (`id`),
index index_yue_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='余额记录';

CREATE TABLE IF NOT EXISTS `address`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `phone` varchar(32) NOT NULL COMMENT '用户手机号',
  `address` text NOT NULL COMMENT '购买地址',
PRIMARY KEY (`id`),
index index_address_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='收货地址';

CREATE TABLE IF NOT EXISTS `user_grade`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `grade` tinyint(1) unsigned NOT NULL COMMENT '用户等级',
  `min` int(11) unsigned NOT NULL COMMENT '最少经验',
  `max` int(11) unsigned NOT NULL COMMENT '最多经验',
  `commission` tinyint(1) unsigned NOT NULL COMMENT '提现手续费率',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户等级表';

CREATE TABLE IF NOT EXISTS `goods_category`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(10) NOT NULL COMMENT '商品分类名称',
  `pic` varchar(128) NOT NULL DEFAULT '' COMMENT '图标',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否推荐',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分类表';

CREATE TABLE IF NOT EXISTS `goods`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `cate_id` int(11) unsigned NOT NULL COMMENT '商品分类',
  `image` json NOT NULL COMMENT '商品图片',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名称',
  `price` decimal(8,2) unsigned NOT NULL COMMENT '商品价格',
  `goods_details` text NOT NULL COMMENT '商品详情',
  `goods_url` varchar(256) NOT NULL DEFAULT '' COMMENT '商品链接',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品表';

CREATE TABLE IF NOT EXISTS `goods_order`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `order_goods` json NOT NULL COMMENT '订单包含的所有商品',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `phone` varchar(32) NOT NULL COMMENT '用户手机号',
  `address` text NOT NULL COMMENT '购买地址',
  `tracking_number` json COMMENT '快递单号',
  `num` decimal(8,2) unsigned NOT NULL COMMENT '实际付款总金额',
  `refund_num` decimal(8,2) unsigned NOT NULL DEFAULT 0 COMMENT '已退款金额',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单状态，防止重复奖励',
  `create_time` datetime NOT NULL COMMENT '记录时间',
PRIMARY KEY (`id`),
index index_rebate_goods_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品订单';

CREATE TABLE IF NOT EXISTS `recharge_order`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户',
  `order_id` char(32) NOT NULL unique COMMENT '订单ID',
  `price` decimal(8,2) unsigned NOT NULL COMMENT '充值金额',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单状态',
  `create_time` datetime NOT NULL COMMENT '记录时间',
PRIMARY KEY (`id`),
index index_recharge_order_status(status),
index index_recharge_order_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='充值订单表';


CREATE TABLE IF NOT EXISTS `blind_box_list`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '盲盒索引',
  `title` varchar(32) NOT NULL COMMENT '盲盒标题',
  `price` decimal(12,2) unsigned NOT NULL COMMENT '盲盒价格',
  `normal` float unsigned NOT NULL COMMENT '普通概率',
  `rare` float unsigned NOT NULL COMMENT '稀有概率',
  `legend` float unsigned NOT NULL COMMENT '传说概率',
  `explosive` float unsigned NOT NULL COMMENT '超神概率',
  `image` text NOT NULL COMMENT '展示图片',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否推荐',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='盲盒列表';

CREATE TABLE IF NOT EXISTS `blind_box_goods_list`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '盲盒商品索引',
  `product_id` mediumint(11) unsigned NOT NULL COMMENT '商品ID',
  `blind_box_id` int(11) unsigned NOT NULL COMMENT '盲盒ID',
  `type` bigint unsigned NOT NULL COMMENT '概率类型',
  `probability` float unsigned NOT NULL COMMENT '抽中概率',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='盲盒商品列表';

CREATE TABLE IF NOT EXISTS `blind_box_order`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单索引',
  `blind_box_id` int(11) unsigned NOT NULL COMMENT '盲盒ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `nums` bigint unsigned NOT NULL COMMENT '购买数量',
  `create_time` date NOT NULL COMMENT '下单时间',
  index index_user_id(user_id),
  index index_order_time(create_time),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='盲盒订单';

CREATE TABLE IF NOT EXISTS `blind_box_winning_record`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '中奖记录索引',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `blind_box_id` int(11) unsigned NOT NULL COMMENT '盲盒ID',
  `product_id` mediumint(11) unsigned NOT NULL COMMENT '商品ID',
  `create_time` date NOT NULL COMMENT '中奖时间',
  `status` bigint unsigned NOT NULL DEFAULT 1 COMMENT '奖品状态1盒柜2回收3领取',
PRIMARY KEY (`id`),
    index index_blind_box_winning_record_time(create_time),
index index_blind_box_winning_record_uid(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='盲盒中奖记录';

CREATE TABLE IF NOT EXISTS `bonus_order`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '报名比赛ID',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `start_date` date NOT NULL COMMENT '开始日期',
  `signed_days` int(1) unsigned DEFAULT 0 NOT NULL COMMENT '已签到的天数',
  `status` tinyint(1) DEFAULT 1 NOT NULL COMMENT '签到状态，1正在进行中，2已完成，-1失败,-2关闭订单',
PRIMARY KEY (`id`),
index index_bonus_order_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='分红订单列表';

CREATE TABLE IF NOT EXISTS `bonus_task`(
  `i` int(11) NOT NULL AUTO_INCREMENT COMMENT '区分索引',
  `id` int(11) unsigned NOT NULL COMMENT '报名比赛的ID',
  `sign_time_morning` bigint unsigned NOT NULL COMMENT '上午签到时间',
  `sign_time_noon` bigint unsigned NOT NULL COMMENT '中午签到时间',
  `sign_time_afternoon` bigint unsigned NOT NULL COMMENT '下午签到时间',
  `morning_sign` tinyint(1) NOT NULL DEFAULT 0 COMMENT '早上签到是否完成',
  `noon_sign` tinyint(1) NOT NULL DEFAULT 0 COMMENT '中午签到是否完成',
  `afternoon_sign` tinyint(1) NOT NULL DEFAULT 0 COMMENT '下午签到是否完成',
  `status` tinyint(1) DEFAULT 1 NOT NULL COMMENT '签到状态，1正在进行中，2已完成，-1失败',
  index index_bonus_task_id(id),
PRIMARY KEY (`i`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='分红任务列表';

CREATE TABLE IF NOT EXISTS `lottery_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户id',
  `num` int(11) unsigned  NOT NULL COMMENT '抽奖金额',
  `points` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '获得的积分数量',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单状态',
  `create_time` datetime NOT NULL COMMENT '抽奖时间',
PRIMARY KEY (`id`),
  index index_lottery_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='银币抽奖记录';

CREATE TABLE IF NOT EXISTS `withdrawal_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) NOT NULL COMMENT '所属用户id',
  `name` varchar(10) NOT NULL COMMENT '支付宝姓名',
  `phone` varchar(20) NOT NULL COMMENT '支付宝手机号',
  `jinbi_num` decimal(65,2) unsigned NOT NULL DEFAULT 0 COMMENT '金币数量',
  `price` decimal(65,2) unsigned NOT NULL DEFAULT 0 COMMENT '实际提现金额',
  `mark` varchar(128) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单状态',
  `create_time` datetime NOT NULL COMMENT '提现时间',
PRIMARY KEY (`id`),
  index index_withdrawal_log_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='提现记录';

CREATE TABLE IF NOT EXISTS `rebate_goods_log`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) unsigned NOT NULL COMMENT '所属用户',
  `order_id` varchar(188) NOT NULL unique COMMENT '返利订单ID，用于查询订单状态',
  `title` varchar(188) NOT NULL COMMENT '商品标题',
  `image` varchar(688) NOT NULL COMMENT '商品图片链接',
  `estimated_income` int(11) unsigned NOT NULL COMMENT '预估收入',
  `payment_fee` int(11) unsigned NOT NULL COMMENT '实付金额',
  `num` int(11) unsigned NOT NULL COMMENT '购买数量',
  `tech_service_amount` int(11) unsigned NOT NULL COMMENT '平台技术服务费',
  `create_time` int(11) unsigned NOT NULL COMMENT '订单创建时间',
PRIMARY KEY (`id`),
index index_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='返利商品所有下单记录';

CREATE TABLE IF NOT EXISTS `rebate_goods_success_log`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) unsigned NOT NULL COMMENT '所属用户',
  `order_id` varchar(188) NOT NULL unique COMMENT '返利订单ID，用于查询订单状态',
  `title` varchar(188) NOT NULL COMMENT '商品标题',
  `image` varchar(688) NOT NULL COMMENT '商品图片链接',
  `estimated_income` int(11) unsigned NOT NULL COMMENT '预估收入',
  `payment_fee` int(11) unsigned NOT NULL COMMENT '实付金额',
  `num` int(11) unsigned NOT NULL COMMENT '购买数量',
  `tech_service_amount` int(11) unsigned NOT NULL COMMENT '平台技术服务费',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '订单状态，防止重复奖励',
  `create_time` int(11) unsigned NOT NULL COMMENT '订单创建时间',
PRIMARY KEY (`id`),
index index_uid(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='返利商品成功返利订单-用于奖励领取，别问为什么，必须要这个表';


CREATE TABLE IF NOT EXISTS `article_log`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) unsigned NOT NULL COMMENT '所属用户',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '推荐1/热门2/精选3/已删除-1',
  `content` text NOT NULL COMMENT '帖子内容',
  `imgs` json COMMENT '帖子图片组',
  `audio` varchar(688) NOT NULL DEFAULT '' COMMENT '音频地址',
  `video` varchar(688) NOT NULL DEFAULT '' COMMENT '视频地址',
  `file_info` json COMMENT '附件信息',
  `file_content` varchar(3000) NOT NULL DEFAULT '' COMMENT '付费内容',
  `create_time` datetime NOT NULL COMMENT '提现时间',
  PRIMARY KEY (`id`),
index index_uid(uid),
index index_create_time(create_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='帖子记录';

CREATE TABLE IF NOT EXISTS `article_comment`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `article_id` int(11) unsigned NOT NULL COMMENT '所属文章',
  `uid` int(11) unsigned NOT NULL COMMENT '所属用户',
  `target_uid` int(11) unsigned NOT NULL COMMENT '回复的用户',
  `content` varchar(500) NOT NULL COMMENT '回复内容',
  `create_time` datetime NOT NULL COMMENT '回复时间',
  `nums` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '被评论次数，用于展示热门文章/评论，也用于是否显示更多评论',
 PRIMARY KEY (`id`),
index index_uid(uid),
index article_id(article_id),
index target_uid(target_uid),
index nums(nums),
index index_create_time(create_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论表';

CREATE TABLE IF NOT EXISTS `pay_log`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录索引',
  `uid` int(11) unsigned NOT NULL unique COMMENT '所属用户',
  `article_file` json COMMENT '文章付费附件信息[{"id":1,"time":9999999","expire":9999999999}]',
  `favorite_posts` json COMMENT '收藏的帖子[{"id":1,"time":9999999","expire":9999999999}]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='付费记录';

-- 举报表 一个字段json保存文章数据 -- 

-- 活跃表，包含最后打开APP的IP和位置以及时间

