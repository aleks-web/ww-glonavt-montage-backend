alias composer="php8.3 ~/.composer/composer.phar"
alias phinx="php8.3 vendor/bin/phinx"
alias gulp="npm run gulp"
alias sass="gulp sass"
alias push="git status && git add . && git commit -m 'standart commit by alias' && git push origin master && git status"


function _prompt {
    export PS1="\[$(tput bold)\]\[\033[38;5;40m\]\u@\H\[$(tput sgr0)\] \[$(tput sgr0)\]\[\033[38;5;40m\]\$(git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/')\[$(tput sgr0)\]: \[$(tput sgr0)\]\[\033[38;5;128m\]\w\[$(tput sgr0)\]: \[$(tput sgr0)\]"
}

PROMPT_COMMAND=_prompt