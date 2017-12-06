PATH_DIST='_dist'
PATH_TEMP='_temp'
PATH_SOURCE='_source'
PATH_TEMPLATE='template'

rm -rf $PATH_TEMP
mkdir -p $PATH_TEMP/archive
mkdir -p $PATH_TEMP/article

if [[ $1 != 'clean' ]]; then
    rm -rf $PATH_SOURCE
    git clone $1 $PATH_SOURCE
    php index.php $PATH_DIST $PATH_TEMP $PATH_SOURCE $PATH_TEMPLATE
fi

rm -rf $PATH_DIST
mkdir $PATH_DIST
cp -af $PATH_TEMP/* $PATH_DIST
