<?php

class Builder {

    /**
     * 遍历所有文章
     * @return [type] [description]
     */
    public static function traverse () {
        return array_reduce(glob(reponame('*')), function ($carry, $item) {
            // 跳过隐藏的目录或文件
            if ($item[0] == '.') {
                return $carry;
            }

            if (is_dir($item)) {
                return $carry + [ $item => glob("$item/*.md") ];
            }

            return $carry;
        }, []);
    }

    /**
     * 文章是否过期
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function expired ($name) {
        if (substr($name, -3) == '.md' && count(explode('/', $name)) > 2) {
            $oth = filename($name, '');
        } else {
            $oth = pathname($name, '');
        }

        if (file_exists(PATH_DIST . $oth)) {
            if (filemtime($name) > filemtime(PATH_DIST . $oth)) {
                return true;
            } else {
                exec(sprintf(
                    'cp -af %s %s',
                    escapeshellarg(PATH_DIST . $oth), escapeshellarg(PATH_TEMP . $oth)
                ));
                return false;
            }
        }
        return true;
    }

    /**
     * 复制静态资源
     * @return [type] [description]
     */
    public static function assets () {
        foreach (glob(PATH_TEMPLATE . '/*') as $v) {
            if (is_dir($v)) {
                exec(sprintf(
                    'cp -af %s %s',
                    escapeshellarg($v), escapeshellarg(PATH_TEMP . '/' . basename($v))
                ));
            }
        }
    }

}
