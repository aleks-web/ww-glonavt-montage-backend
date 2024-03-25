alias composer="php8.2 ~/.composer/composer.phar"

function _prompt {
    export PS1="\[$(tput bold)\]\[\033[38;5;40m\]\u@\H\[$(tput sgr0)\] \[$(tput sgr0)\]\[\033[38;5;40m\]\$(git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/')\[$(tput sgr0)\]: \[$(tput sgr0)\]\[\033[38;5;128m\]\w\[$(tput sgr0)\]: \[$(tput sgr0)\]"
}

PROMPT_COMMAND=_prompt