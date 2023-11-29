<?php
/*
 * @Author: Your Name you@example.com
 * @Date: 2023-05-21 17:11:39
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @LastEditTime: 2023-05-22 11:31:39
 * @FilePath: /testshop.jiechurenlei.com/config/cache.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'redis'),

    // 缓存连接方式配置
    'stores'  => [
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // redis缓存
        'redis'   =>  [
            // 驱动方式
            'type'          => 'redis',
            // 服务器地址
            'host'          => env('redis.redis_hostname', '127.0.0.1'),
            // 端口
            'port'          => env('redis.port', '6379'),
            // 密码
            'password'      => env('redis.redis_password', ''),
            // 缓存有效期 0表示永久缓存
            'expire'        => 3600 ,
            // 缓存前缀
            'prefix'        => env('cache.prefix', ''),
            // 缓存标签前缀
            'tag_prefix'    => env('cache.tag_prefix', '').'jiechurenlei:',
            // 数据库 0号数据库
            'select'        => intval(env('redis.select', 0)),
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'     => [],
            // 服务端主动关闭
            'timeout'       => 0
        ],
        // redis缓存
        'redis_permanent'   =>  [
            // 驱动方式
            'type'          => 'redis',
            // 服务器地址
            'host'          => env('redis.redis_hostname', '127.0.0.1'),
            // 端口
            'port'          => env('redis.port', '6379'),
            // 密码
            'password'      => env('redis.redis_password', ''),
            // 缓存有效期 0表示永久缓存
            'expire'        => 0 ,
            // 缓存前缀
            'prefix'        => env('cache.prefix', ''),
            // 缓存标签前缀
            'tag_prefix'    => env('cache.tag_prefix', '').'jiechurenlei:',
            // 数据库 0号数据库
            'select'        => intval(env('redis.select', 1)),
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'     => [],
            // 服务端主动关闭
            'timeout'       => 0
        ]
    ],
];
