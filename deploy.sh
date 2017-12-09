#!/bin/bash
PATH_PWD=$(pwd)
PATH_DIST='_dist'
PATH_TEMP='_temp'
PATH_SOURCE='_source'
PATH_TEMPLATE='template'

if [ $1 != 'push' ]; then
    rm -rf $PATH_TEMP
    rm -rf $PATH_SOURCE
fi

if type gtouch > /dev/null 2>&1; then
    TOUCH='gtouch'
else
    TOUCH='touch'
fi

if [[ $1 == 'clean' ]]; then
    echo 'ok'
elif [[ $1 == 'push' ]]; then
    cd $PATH_DIST
    git add -A
    git commit -m 'auto deploy by blog-deploy'
    git push -u $2 master
else
    mkdir -p $PATH_TEMP/article
    mkdir -p $PATH_TEMP/category

    git config --global core.quotepath false
    git clone $2 $PATH_SOURCE
    if [ -d $PATH_DIST ]; then
        cd $PATH_DIST
        git pull
        cd $PATH_PWD
    else
        git clone $1 $PATH_DIST
    fi

    cd $PATH_SOURCE
    git ls-files | while read line; do
        $TOUCH -md $(git log -1 --format='@%at' "$line") "$line"
        $TOUCH -ad $(git log --format='@%at' "$line" | tail -1) "$line"
    done
    cd $PATH_PWD

    php index.php $PATH_DIST $PATH_TEMP $PATH_SOURCE $PATH_TEMPLATE
    cp -af $PATH_TEMP/* $PATH_DIST
fi
