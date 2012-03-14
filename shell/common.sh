version()
{
    echo "${PROGRAM_NAME} ${PROGRAM_VERSION}"
    exit 1
}

# echo to stdout
echoo()
{
    printf "$*\n"
}

# echo to stderr
echoe()
{
    printf "$*\n" 1>&2
}

# $1: installDir
install()
{
    installDir="/usr/bin"
    if [ $# -ge 1 ]; then
        installDir="$1"
    fi
        
    cp "$0" "${installDir}"
    ret=$?
    if [ "${ret}" = 0 ]; then
        echoo "Install $PROGRAM_NAME finished."
    fi
    exit "${ret}"
}

executeCommand()
{
    _command="$1"
    _isExecute="$2"
    _isQuiet="$3"
    _isStop="$4"
    
    [ "$_isQuiet" != 1 ] && echoo "Executing command \`${_command}' ..."
    if [ "${_isExecute}" != "0" ]; then
        eval "${_command}"
        if [ $? != 0 ]; then
            echoo "Execute command \`${_command}' failed."
            if [ "$_isStop" = 1 ]; then
                exit 1
            fi
        fi
    fi
}

normalizePath()
{
    local path="$1"
    local dir=$(dirname "$path")
    local basename=$(basename "$path")

    if [ ! -r "$path" ]; then
        if [[ "$dir" != "." ]]; then
            path="$dir/$basename"
        else
            path="$basename"                                                                                                               
        fi
    else
        path="$(cd "$dir" && pwd)/$basename"
    fi

    echo "$path"
}
