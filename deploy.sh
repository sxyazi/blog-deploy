PATH_DIST='_dist'
PATH_TEMP='_temp'
PATH_SOURCE='_source'
PATH_TEMPLATE='template'

rm -rf $PATH_DIST
rm -rf $PATH_TEMP
rm -rf $PATH_SOURCE

mkdir -p $PATH_TEMP/archive
mkdir -p $PATH_TEMP/article

if [[ $1 != 'clean' ]]; then
    git clone $1 $PATH_DIST
    git clone $2 $PATH_SOURCE
    php index.php $PATH_DIST $PATH_TEMP $PATH_SOURCE $PATH_TEMPLATE
    cd $PATH_DIST
    cp -af $PATH_TEMP/* .
    git push -u $1 master
fi
