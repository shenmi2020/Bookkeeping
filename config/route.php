<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

Route::any('/user/login', [app\controller\User::class, 'login'])->middleware([
    // app\middleware\AuthCheck::class
]);
Route::any('/', [app\controller\Index::class, 'index']);


Route::any('/user/demo1', [app\controller\User::class, 'demo1'])->middleware([
    // app\middleware\AuthCheck::class
]);
Route::any('/user/demo2', [app\controller\User::class, 'demo2'])->middleware([
    app\middleware\AuthCheck::class
]);

Route::group('/wx', function () {
    // 账本
    Route::post('/account', [app\controller\Account::class, 'listInfo']);
    // 记录
    Route::post('/record/add', [app\controller\Record::class, 'add']);
    Route::post('/record', [app\controller\Record::class, 'listInfo']);
    // 分类
    Route::post('/category', [app\controller\Category::class, 'listInfo']);
})->middleware([
    app\middleware\AuthCheck::class
]);
Route::disableDefaultRoute();