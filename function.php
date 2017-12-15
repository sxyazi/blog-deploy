<?php

/**
 * 文件名哈希
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function hex ($name) {
    return substr(md5($name), 0, 16);
}

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
    return "$prefix/article/" . hex($name) . '.html';
}

/**
 * 目录对应的名字
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function pathname ($name, $prefix = PATH_TEMP) {
    return "$prefix/category/" . implode('/', array_slice(explode('/', $name), -1)) . '.html';
}

/**
 * 仓库文件对应的名字
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function reponame ($name) {
    return PATH_SOURCE . '/' . $name;
}

/**
 * 文件树
 * @param  [type] $task [description]
 * @return [type]       [description]
 */
function filetree ($task) {
    return array_reduce(array_keys($task), function ($carry, $item) use ($task) {
        return $carry + [
            basename($item) => array_map(function ($v) {
                return [
                    'id'    => hex($v),
                    'file'  => $v,
                    'name'  => basename($v, '.md'),
                    'ctime' => fileatime($v),
                    'mtime' => filemtime($v)
                ];
            }, $task[$item])
        ];
    }, []);
}

/**
 * 文件列表
 * @param  [type] $tree [description]
 * @return [type]       [description]
 */
function filelist ($tree) {
    $list = [];
    foreach ($tree as $v) {
        $list = array_merge($list, $v);
    }

    usort($list, function ($a, $b) {
        return $a['ctime'] < $b['ctime'] ? 1 : -1;
    });

    return $list;
}

/**
 * 文件信息
 * @param  [type] $tree [description]
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function fileinfo ($list, $name) {
    $key = array_search($name, array_column($list, 'file'));
    return $key === false ? [] : $list[$key];
}
