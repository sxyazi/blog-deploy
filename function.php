<?php

/**
 * 设置 a 文件时间与 b 文件一致
 * @param  [type] $a [description]
 * @param  [type] $b [description]
 * @return [type]    [description]
 */
function keeptime ($a, $b) {
    exec(sprintf('touch -r %s %s', escapeshellarg($b), escapeshellarg($a)));
}

/**
 * 文件对应的名字
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function filename ($name, $prefix = PATH_TEMP) {
    return "$prefix/article/" . substr(md5($name), 0, 16) . '.html';
}

/**
 * 目录对应的名字
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function pathname ($name, $prefix = PATH_TEMP) {
    return "$prefix/archive/" . implode('/', array_slice(explode('/', $name), 1)) . '.html';
}

/**
 * 仓库文件对应的名字
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function reponame ($name) {
    return PATH_SOURCE . '/' . $name;
}
