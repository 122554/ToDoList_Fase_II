/* Alternância de tema claro/escuro. A escolha fica salva no navegador. */

(function () {
    'use strict';

    var raiz = document.documentElement;
    var CHAVE = 'tema';

    function lerSalvo() {
        try {
            var salvo = localStorage.getItem(CHAVE);
            return salvo === 'claro' || salvo === 'escuro' ? salvo : null;
        } catch (e) {
            return null;
        }
    }

    function salvar(tema) {
        try {
            localStorage.setItem(CHAVE, tema);
        } catch (e) {
            /* Armazenamento indisponível: o tema vale apenas nesta página. */
        }
    }

    function temaDoSistema() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'escuro'
            : 'claro';
    }

    function atualizarBotoes() {
        var escuro = raiz.getAttribute('data-tema') === 'escuro';
        var rotulo = escuro ? 'Ativar tema claro' : 'Ativar tema escuro';

        document.querySelectorAll('[data-alternar-tema]').forEach(function (botao) {
            botao.setAttribute('aria-pressed', escuro ? 'true' : 'false');
            botao.setAttribute('aria-label', rotulo);
            botao.setAttribute('title', rotulo);
        });
    }

    function aplicar(tema) {
        raiz.setAttribute('data-tema', tema);
        atualizarBotoes();
    }

    /* Aplica o tema antes da renderização, evitando o flash de cor */
    aplicar(lerSalvo() || temaDoSistema());

    document.addEventListener('DOMContentLoaded', atualizarBotoes);

    document.addEventListener('click', function (evento) {
        if (!evento.target.closest('[data-alternar-tema]')) {
            return;
        }

        var novo = raiz.getAttribute('data-tema') === 'escuro' ? 'claro' : 'escuro';
        aplicar(novo);
        salvar(novo);
    });

    /* Sem escolha salva, acompanha o tema do sistema */
    if (window.matchMedia) {
        var sistema = window.matchMedia('(prefers-color-scheme: dark)');

        if (sistema.addEventListener) {
            sistema.addEventListener('change', function (evento) {
                if (!lerSalvo()) {
                    aplicar(evento.matches ? 'escuro' : 'claro');
                }
            });
        }
    }

    /* Sincroniza o tema entre abas abertas */
    window.addEventListener('storage', function (evento) {
        if (evento.key === CHAVE && (evento.newValue === 'claro' || evento.newValue === 'escuro')) {
            aplicar(evento.newValue);
        }
    });
})();
