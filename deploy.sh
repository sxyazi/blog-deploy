PATH_PWD=$(pwd)
PATH_DIST='_dist'
PATH_TEMP='_temp'
PATH_SOURCE='_source'
PATH_TEMPLATE='template'

if [[ $1 != 'push' ]]; then
    rm -rf $PATH_DIST
    rm -rf $PATH_TEMP
    rm -rf $PATH_SOURCE
fi

if [[ $1 == 'clean' ]]; then
    echo 'ok'
elif [[ $1 == 'push' ]]; then
    cd $PATH_DIST
    git add -A
    git commit -m 'auto deploy by blog-deploy'
    git push -u $1 master
else
    mkdir -p $PATH_TEMP/archive
    mkdir -p $PATH_TEMP/article

    git clone $1 $PATH_DIST
    git clone $2 $PATH_SOURCE
    git config core.quotepath false

    cd $PATH_SOURCE
    git ls-files | while read line; do
        touch -md $(git log -1 --format='@%at' "$line") "$line"
        touch -ad $(git log --format='@%at' "$line" | tail -1) "$line"
    done
    cd $PATH_PWD

    php index.php $PATH_DIST $PATH_TEMP $PATH_SOURCE $PATH_TEMPLATE
    cp -af $PATH_TEMP/* $PATH_DIST
fi
