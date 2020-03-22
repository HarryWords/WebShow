<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'likunkeji');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'harryword123');

/** MySQL主机 */
define('DB_HOST', '127.0.0.1');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'V5Z;Q%;-dpLz5YNa*fnOQQB]CY%snGALcG&;+#qh$#_1vwBq:r7|&?N#sFc*b?=s');
define('SECURE_AUTH_KEY',  ']6FY pAM&*G^wmg|:#u@^G_&q[)i72[dPkz:+&|kMPw cVtx<8J$kTq@KP9[dq4+');
define('LOGGED_IN_KEY',    'BAWWmeDFA <C`EX6QGbPzT]2^jAF,if`!ae]13f&LS;?nv8U|h(W@m|uh>Jpg=9&');
define('NONCE_KEY',        '}dt@gPSR?]I`WzHHU*t&+[IcK<6m]jC6+x&6D39S%r3D{R}Yx@+Xzuw0L35C.NWv');
define('AUTH_SALT',        '{QSUzh%OeFl$&r+:JQDHn:q|Ms2}2$$f&5 {o>*,g6HRX$!nDI#9H:IhQM7d)WaW');
define('SECURE_AUTH_SALT', '9xCpUY]?t-lwbWxV5N1!603=k7M7aQaPmU8FFa!Vu2}|F6Tg9<sn//,vNmw{psGO');
define('LOGGED_IN_SALT',   ')i]}Gf*Yj^iR%D_e2ZjQi$wKPg0qVHDM]Gf_oUt1nBJ)2BnPbw-TC=nouPM|9XoD');
define('NONCE_SALT',       '~G1&I`%E3gN>7z]*P<NF]dN{^qU!pp BV Zk5H8W5cj.@THOyMZ_Jx}!-i(]A3d$');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'lk_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
define("FS_METHOD", "direct");
define("FS_CHMOD_DIR", 0777);
define("FS_CHMOD_FILE", 0777);
define('WP_ALLOW_REPAIR', true);
// 解决后台 慢 
define('CONCATENATE_SCRIPTS', false);
