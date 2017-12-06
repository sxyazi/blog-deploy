<?php

class Render {

    /**
     * 处理方法
     * @return [type] [description]
     */
    public static function handle ($list) {
        foreach ($list as $archive => $article) {

            // 文章
            array_map('Render::article', $article);

            // 分类
            self::archive($archive, $article);

        }

        // 自定义页面
        self::custom();
    }

    /**
     * 通用方法
     * @param  [type] $f   [description]
     * @param  [type] $arg [description]
     * @return [type]      [description]
     */
    public static function generic ($f, $arg) {
        ob_start();
        extract($arg);
        require(PATH_TEMPLATE . '/' . $f . '.php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * 文章
     * @param  [type] $aname 文章文件名（.md 文件）
     * @param  [type] $bname 写到文件的名称
     * @return [type]        [description]
     */
    public static function article ($name) {
        $file = filename($name);

        file_put_contents($file, self::generic('article', [
            'content' => file_get_contents($name)
        ]));

        keeptime($file, $name);
    }

    /**
     * 归档
     * @param  [type] $archive [description]
     * @param  [type] $article [description]
     * @return [type]          [description]
     */
    public static function archive ($archive, $article) {
        $file = pathname($archive);

        // 检查目录是否存在
        if (!is_dir($dir = dirname($file))) {
            exec(sprintf('mkdir -p %s', escapeshellarg($dir)));
        }

        $list = array_map(function ($v) {
            return [
                'file'  => filename($v),
                'title' => rtrim(basename($v), '.md'),
                'ctime' => filectime($v),
                'mtime' => filemtime($v),
            ];
        }, $article);

        file_put_contents($file, self::generic('archive', [
            'list' => $list,
            'name' => basename($archive)
        ]));

        keeptime($file, $archive);
    }

    /**
     * 自定义页面
     * @return [type] [description]
     */
    public static function custom () {
        $config = [];
        $ignore = [ 'article', 'archive' ];

        // 配置文件存在
        if (is_file(reponame('blog.yml'))) {
            $config = Spyc::YAMLLoadString(preg_replace(
                '/([\r\n]+)/', "$1\n", file_get_contents(reponame('blog.yml'))
            ));
        }

        foreach (glob(PATH_TEMPLATE . '/*.php') as $v) {
            $name = basename($v, '.php');
            if (in_array($name, $ignore)) {
                continue;
            }

            file_put_contents(PATH_TEMP . "/$name.html", self::generic($name, [
                'config' => $config
            ]));
        }
    }

}
