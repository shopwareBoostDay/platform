import template from './sw-mail-template-index.html.twig';

const { Component } = Shopware;

Component.register('sw-mail-template-index', {
    template,

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    data() {
        return {
           searchTerm: ''
        };
    },

    methods: {
        onChangeLanguage(languageId) {
            Shopware.State.commit('context/setApiLanguageId', languageId);
            this.$refs.mailHeaderFooterList.getList();
            this.$refs.mailTemplateList.getList();
        },
        onSearch(value) {
            this.searchTerm = value;
        },
    }
});
