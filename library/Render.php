<?php

class Render {
    public $list = [];

    public function __construct ($list) {
        $this->list = $list;
        $this->handle();
    }

    /**
     * 处理方法
     * @return [type] [description]
     */
    public function handle () {
        foreach ($this->list as $cate => $article) {

            if (!Builder::expired($cate)) {
                continue;
            }

            // 分类
            $this->category($cate, $article);

            // 文章
            array_map([ $this, 'article' ], array_filter($article, 'Builder::expired'));

        }

        // 自定义页面
        $this->custom();
    }

    /**
     * 通用方法
     * @param  [type] $f   [description]
     * @param  [type] $arg [description]
     * @return [type]      [description]
     */
    public function generic ($f, $arg) {
        ob_start();
        extract($arg);
        require(PATH_TEMPLATE . '/' . $f . '.php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * 文章
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function article ($name) {
        $file = filename($name);

        file_put_contents($file, $this->generic('article', [
            'content' => file_get_contents($name)
        ]));

        keeptime($file, $name);
    }

    /**
     * 归档
     * @param  [type] $cate    [description]
     * @param  [type] $article [description]
     * @return [type]          [description]
     */
    public function category ($cate, $article) {
        $file = pathname($cate);

        // 检查目录是否存在
        if (!is_dir($dir = dirname($file))) {
            exec(sprintf('mkdir -p %s', escapeshellarg($dir)));
        }

        $list = array_map(function ($v) {
            return [
                'id'    => hex($v),
                'file'  => $v,
                'name'  => basename($v, '.md'),
                'ctime' => fileatime($v),
                'mtime' => filemtime($v),
            ];
        }, $article);

        file_put_contents($file, $this->generic('category', [
            'list' => $list,
            'name' => basename($cate)
        ]));

        keeptime($file, $cate);
    }

    /**
     * 自定义页面
     * @return [type] [description]
     */
    public function custom () {
        $ignore = [ 'article', 'category' ];

        // 模板变量
        $var         = [ 'config' => [] ];
        $var['tree'] = filetree($this->list);
        $var['list'] = filelist($var['tree']);

        // 配置文件存在
        if (is_file(reponame('blog.yml'))) {
            $var['config'] = Spyc::YAMLLoadString(preg_replace(
                '/([\r\n]+)/', "$1\n", file_get_contents(reponame('blog.yml'))
            ));
        }

        foreach (glob(PATH_TEMPLATE . '/*.php') as $v) {
            $name = basename($v, '.php');
            if (in_array($name, $ignore)) {
                continue;
            }

            file_put_contents(PATH_TEMP . "/$name.html", $this->generic($name, $var));
        }
    }

}
